<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Models\Producto;
use App\Models\Inventario;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class InventarioAsigImport implements WithHeadingRow, ToModel, WithChunkReading
{
    private $tiendas;

    public function __construct($tiendas)
    {
        $this->tiendas = $tiendas;
    }
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */

    public function model(array $row)
    {
        $producto = Producto::where('sku', $row['sku'])->first();
        if ($producto == null) {
            $producto = Producto::create([
                'sku' => $row['sku'],
                'externo' => $row['externo'],
                'producto' => $row['producto'],
                'grupo' => $row['grupo'],
                'seccion' => $row['seccion'],
                'clasificacion' => $row['clasificacion'],
                'proveedor' => $row['proveedor'],
                'estilo' => $row['estilo'],
                'color' => $row['color'],
                'talla' => $row['talla'],
                'marca' => $row['marca'],
                'inventario_costo' => $row['inventario_costo'],
                'inventario_venta' => $row['inventario_venta'],
                'ultimo_movimiento' =>  Carbon::createFromFormat('d/m/Y H:i:s', $row['ultimo_movimiento'])->format('Y-m-d H:i:s'),
                'ultima_venta' =>  Carbon::createFromFormat('d/m/Y H:i:s', $row['ultima_venta'])->format('Y-m-d H:i:s'),
                'ultima_recepcion' =>  Carbon::createFromFormat('d/m/Y H:i:s', $row['ultima_recepcion'])->format('Y-m-d H:i:s'),
            ]);
        }
        foreach ($this->tiendas as $tienda) {
            $inventario = Inventario::where('tienda', $tienda->id)
                ->where('producto', $producto->id)                
                ->first();
            if ($inventario != null) {
                $tienda_nombre = str_replace(' ', '_', $tienda->tienda);
                if (isset($row[$tienda_nombre])) {                    
                    $inventario->update([
                        'tienda' => $tienda->id,
                        'producto' => $producto->id,
                        'cantidad' => $row[$tienda_nombre],
                        'fecha_corte' => Carbon::createFromFormat('d/m/Y', $row['fecha_corte'])->format('Y-m-d')
                    ]);
                }
            } else {
                $tienda_nombre = str_replace(' ', '_', strtolower($tienda->tienda));                
                if (isset($row[$tienda_nombre])) {
                    Inventario::create([
                        'tienda' => $tienda->id,
                        'producto' => $producto->id,
                        'cantidad' => $row[$tienda_nombre],
                        'fecha_corte' => Carbon::createFromFormat('d/m/Y', $row['fecha_corte'])->format('Y-m-d')
                    ]);
                }
            }
        }

        return null;
    }

    public function chunkSize(): int
    {
        return 500;
    }
}
