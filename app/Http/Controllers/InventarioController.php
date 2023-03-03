<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\InventarioImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\InventarioAsigImport;
use App\Models\Inventario;
use Illuminate\Support\Facades\DB;

class InventarioController extends Controller
{
    public function cargar_excel(Request $request){
        $path = $request->file('archivo_excel')->getRealPath();
        Excel::import(new InventarioImport, $path);

        return response()->json([
            'message' => 'ok'
        ]);
    }

    public function carga_data(Request $request){
        $path = $request->file('archivo_excel')->getRealPath();
        $asignacion = json_decode($request->asignacion);

        Excel::import(new InventarioAsigImport($asignacion), $path);

        return response()->json([
            'message' => 'ok'
        ]);
    }

    public function get_inventario(){
        // return Inventario::all();
        $inventario = DB::table('inventarios')
        ->join('productos', 'productos.id', '=', 'inventarios.producto')
        ->join('tiendas', 'tiendas.id', '=', 'inventarios.tienda')
        ->select('productos.*')
        ->get();
        return response()->json($inventario);
    }
}
