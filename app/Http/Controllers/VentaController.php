<?php

namespace App\Http\Controllers;

use App\Imports\VentasImport;
use App\Models\Venta;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class VentaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function carga_data(Request $request)
    {
        $path = $request->file('archivo_excel')->getRealPath();

        Excel::import(new VentasImport, $path);

        return response()->json([
            'message' => 'ok'
        ]);
    }

    public function get_punto_operacion()
    {
        $punto_operacion = Venta::select('punto_operacion')->distinct()->get();        
        return $punto_operacion;
    }

    public function get_reporte_ventas_marca(Request $request)
    {   
        $fecha_inicio = Carbon::parse($request->fechaInicio)->subDay()->format('Y-m-d');
        $fecha_fin = Carbon::parse($request->fechaFin)->subDay()->format('Y-m-d');             

        $operaciones = collect($request->puntoOperacion);        
        $operaciones = $operaciones->map(function($item){
            return $item['punto_operacion'];
        });

        $ciudades = collect($request->ciudad);
        $ciudades = $ciudades->map(function($item){
            return $item['ciudad'];
        });

        $tiendas = collect($request->tienda);
        $tiendas = $tiendas->map(function($item){
            return $item['tienda'];
        });

        $ventas = Venta::whereBetween('fecha', [$fecha_inicio, $fecha_fin]);
        $ventas->join('productos', 'ventas.producto_id', '=', 'productos.id');
        if($operaciones->count() > 0){
            $ventas->whereIn('punto_operacion', $operaciones);
        }

        if($ciudades->count() > 0){
            $ventas->whereHas("tienda", function ($q) use ($ciudades) {
                $q->whereIn('ciudad', $ciudades);
            });
        }

        if($tiendas->count() > 0){
            $ventas->whereHas("tienda", function ($q) use ($tiendas) {
                $q->whereIn('tienda', $tiendas);
            });
        }

        $ventas->selectRaw('marca, count(ventas.id) as transacciones_total ,sum(cantidad) as cantidad, sum(total) as total , sum(descuento_sistema) as descuento_final,sum(gm) as sum_gm, tienda_id');
        $ventas->groupBy(['marca', 'tienda_id']);

        return $ventas->get();
    }
}
