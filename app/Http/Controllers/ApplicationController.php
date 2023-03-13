<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Http\Controllers\Controller;
use App\Models\Inventario;

class ApplicationController extends Controller
{
    public function __invoke()
    {
        return view('application');
    }

    public function dataDashboard()
    {
        $anio = date('Y');
        $unidadesVendidas = Venta::whereYear('fecha', $anio)->selectRaw('sum(cantidad) as unidades')->first();      
        $ventas = Venta::whereYear('fecha', $anio)->selectRaw('sum(total) as total')->first();           
        $inventario = Inventario::whereYear('fecha_corte', $anio)->selectRaw('sum(cantidad) as total')->first();
        $costo = Inventario::whereYear('fecha_corte', $anio)
        ->join('productos', 'inventarios.producto', '=', 'productos.id')
        ->selectRaw('SUM(inventarios.cantidad * productos.inventario_costo) AS costo')->first();

        $ventasAnios = Venta::selectRaw('YEAR(fecha) AS year,MONTH(fecha) AS month, SUM(total) as total')
        ->groupBy('year', 'month')
        ->orderBy('year', 'desc')
        ->orderBy('month')
        ->get();
        
        return response()->json([
            'unidades' => $unidadesVendidas->unidades,
            'ventas' => round($ventas->total, 2),
            'inventario' => $inventario->total,
            'costo' => round($costo->costo, 0),
            'grafico' => $ventasAnios,
        ]);
    }
}
