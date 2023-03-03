<?php

namespace App\Imports;

use App\Models\Producto;
use App\Models\tienda;
use App\Models\Venta;
use Maatwebsite\Excel\Concerns\ToModel;

class VentasImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    private $asignacion;

    public function __construct($asignacion)
    {
        $this->asignacion = $asignacion;
    }

    public function model(array $row)
    {
        // dd($row['tienda']);
        // $tienda = tienda::where('tienda', $row['tienda'])->where('ciudad', $row['ciudad'])->first()->id;
        // if (!$tienda) {
        //     $create = tienda::create([
        //         'tienda' => $row['tienda'],
        //         'ciudad' => $row['ciudad']
        //     ]);
        //     $tienda = $create->id;
        // }

        // return new Venta([
        //     'tienda_id'     => $tienda,
        // ]);
    }
}
