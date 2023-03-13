<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\InventarioImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\InventarioAsigImport;
use App\Models\Inventario;
use App\Models\tienda;

class InventarioController extends Controller
{
    public function cargar_excel(Request $request){
        try{
            $path = $request->file('archivo_excel')->getRealPath();
            Excel::import(new InventarioImport, $path);
    
            return response()->json([
                'message' => 'ok'
            ]);
        }catch(\Throwable $th){
            return $th;
        }
    }

    public function carga_data(Request $request){
        $path = $request->file('archivo_excel');
        $tiendas = tienda::where('estado', 1)->get();

        Excel::import(new InventarioAsigImport($tiendas), $path);

        return response()->json([
            'message' => 'ok'
        ]);
    }

    public function get_reporte_existencia(Request $request){
        try {
            $ciudades = collect($request->ciudad);
            $ciudades = $ciudades->map(function ($item) {
                return $item['ciudad'];
            });
    
            $tiendas = collect($request->tienda);
            $tiendas = $tiendas->map(function ($item) {
                return $item['tienda'];
            });
    
            $inventario = Inventario::join('productos', 'inventarios.producto', '=', 'productos.id')
            ->join('tiendas', 'inventarios.tienda', '=', 'tiendas.id');
    
            if ($ciudades->count() > 0) {
                $inventario->whereIn('tiendas.ciudad', $ciudades);            
            }
            if ($tiendas->count() > 0) {
                $inventario->whereIn('tiendas.tienda', $tiendas);
            }
            $inventario->selectRaw('tiendas.tienda as nombre_tienda,productos.marca , sum(cantidad) as cantidad, SUM(productos.inventario_costo) AS costo')
            ->groupBy('tiendas.tienda','productos.marca');
            return $inventario->get();
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
}
