<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\InventarioImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\InventarioAsigImport;

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
}
