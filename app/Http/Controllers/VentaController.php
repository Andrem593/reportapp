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
        $path = $request->file('archivo_excel');

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
        $operaciones = $operaciones->map(function ($item) {
            return $item['punto_operacion'];
        });

        $ciudades = collect($request->ciudad);
        $ciudades = $ciudades->map(function ($item) {
            return $item['ciudad'];
        });

        $tiendas = collect($request->tienda);
        $tiendas = $tiendas->map(function ($item) {
            return $item['tienda'];
        });

        $ventas = Venta::whereBetween('fecha', [$fecha_inicio, $fecha_fin]);
        $ventas->join('productos', 'ventas.producto_id', '=', 'productos.id');
        if ($operaciones->count() > 0) {
            $ventas->whereIn('punto_operacion', $operaciones);
        }

        if ($ciudades->count() > 0) {
            $ventas->whereHas("tienda", function ($q) use ($ciudades) {
                $q->whereIn('ciudad', $ciudades);
            });
        }

        if ($tiendas->count() > 0) {
            $ventas->whereHas("tienda", function ($q) use ($tiendas) {
                $q->whereIn('tienda', $tiendas);
            });
        }

        $ventas->selectRaw('year(ventas.fecha) AS year, marca, count(ventas.id) as transacciones_total ,sum(cantidad) as cantidad, sum(total) as total , sum(descuento_sistema) as descuento_final,avg(gm) as prom_gm, tienda_id');
        $ventas->groupBy(['year' ,'marca', 'tienda_id']);
        $ventas->orderBy('year'); 
        $ventas = $ventas->get();
        $anios = Venta::whereBetween('fecha', [$fecha_inicio, $fecha_fin])
        ->selectRaw('year(fecha) AS year')->groupBy('year')->get();
        return response()->json([
            'ventas' => $ventas,
            'anios' => $anios
        ]);
    }

    public function get_reporte_ventas_operacion(Request $request)
    {
        $fecha_inicio = Carbon::parse($request->fechaInicio)->subDay()->format('Y-m-d');
        $fecha_fin = Carbon::parse($request->fechaFin)->subDay()->format('Y-m-d');

        $operaciones = collect($request->puntoOperacion);
        $operaciones = $operaciones->map(function ($item) {
            return $item['punto_operacion'];
        });

        $ciudades = collect($request->ciudad);
        $ciudades = $ciudades->map(function ($item) {
            return $item['ciudad'];
        });

        $tiendas = collect($request->tienda);
        $tiendas = $tiendas->map(function ($item) {
            return $item['tienda'];
        });

        $ventas =  Venta::whereBetween('fecha', [$fecha_inicio, $fecha_fin]);
        
        if ($operaciones->count() > 0) {
            $ventas->whereIn('punto_operacion', $operaciones);
        }
        if ($ciudades->count() > 0) {
            $ventas->whereHas("tienda", function ($q) use ($ciudades) {
                $q->whereIn('ciudad', $ciudades);
            });
        }
        if ($tiendas->count() > 0) {
            $ventas->whereHas("tienda", function ($q) use ($tiendas) {
                $q->whereIn('tienda', $tiendas);
            });
        }
        $ventas->selectRaw('year(ventas.fecha) AS year,punto_operacion, count(ventas.id) as transacciones_total ,sum(cantidad) as cantidad, sum(total) as total , sum(descuento_sistema) as descuento_final,avg(gm) as prom_gm, tienda_id');
        $ventas->groupBy(['year','tienda_id','punto_operacion']);
        $ventas->orderBy('year'); 
        $ventas = $ventas->get();
        $anios = Venta::whereBetween('fecha', [$fecha_inicio, $fecha_fin])
        ->selectRaw('year(fecha) AS year')->groupBy('year')->get();
        return response()->json([
            'ventas' => $ventas,
            'anios' => $anios
        ]);
    }

    public function get_reporte_ventas_clasificacion(Request $request)
    {
        $fecha_inicio = Carbon::parse($request->fechaInicio)->subDay()->format('Y-m-d');
        $fecha_fin = Carbon::parse($request->fechaFin)->subDay()->format('Y-m-d');

        $operaciones = collect($request->puntoOperacion);
        $operaciones = $operaciones->map(function ($item) {
            return $item['punto_operacion'];
        });

        $ciudades = collect($request->ciudad);
        $ciudades = $ciudades->map(function ($item) {
            return $item['ciudad'];
        });

        $tiendas = collect($request->tienda);
        $tiendas = $tiendas->map(function ($item) {
            return $item['tienda'];
        });

        $ventas =  Venta::whereBetween('fecha', [$fecha_inicio, $fecha_fin]);
        $ventas->join('productos', 'ventas.producto_id', '=', 'productos.id');
        if ($operaciones->count() > 0) {
            $ventas->whereIn('punto_operacion', $operaciones);
        }
        if ($ciudades->count() > 0) {
            $ventas->whereHas("tienda", function ($q) use ($ciudades) {
                $q->whereIn('ciudad', $ciudades);
            });
        }
        if ($tiendas->count() > 0) {
            $ventas->whereHas("tienda", function ($q) use ($tiendas) {
                $q->whereIn('tienda', $tiendas);
            });
        }
        $ventas->selectRaw('year(ventas.fecha) AS year,productos.clasificacion, count(ventas.id) as transacciones_total ,sum(cantidad) as cantidad, sum(total) as total , sum(descuento_sistema) as descuento_final,avg(gm) as prom_gm, tienda_id');
        $ventas->groupBy(['year','tienda_id','productos.clasificacion']);
        $ventas->orderBy('year'); 
        $ventas = $ventas->get();
        $anios = Venta::whereBetween('fecha', [$fecha_inicio, $fecha_fin])
        ->selectRaw('year(fecha) AS year')->groupBy('year')->get();
        return response()->json([
            'ventas' => $ventas,
            'anios' => $anios
        ]);
    }
}
