<?php

namespace App\Imports;

use App\Models\Inventario;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class InventarioImport implements WithHeadingRow, ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */

    public function model(array $row)
    {
        return new Inventario([
            'sku'     => $row['sku'],
            'externo'    => $row['externo'],
            'producto' => $row['producto'],
        ]);
    }
}
