<?php

namespace App\Imports;

use App\Inventario;
use Maatwebsite\Excel\Concerns\ToModel;

class InventarioImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Inventario([
            'sku'     => $row[0],
            'externo'    => $row[1],
            'producto' => $row[2],
        ]);
    }
}
