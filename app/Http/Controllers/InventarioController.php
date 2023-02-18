<?php

namespace App\Http\Controllers;

use App\Imports\InventarioImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class InventarioController extends Controller
{
    public function cargar_excel(Request $request){
        $path = $request->file('archivo_excel')->getRealPath();
        Excel::import(new InventarioImport, $path);
    }
}
