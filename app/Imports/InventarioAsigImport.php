<?php

namespace App\Imports;

use App\Models\Producto;
use App\Models\Inventario;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class InventarioAsigImport implements WithHeadingRow, ToModel
{
    private $asignacion;

    public function __construct($asignacion)
    {
        $this->asignacion = $asignacion;
    }
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */

    public function model(array $row)
    {
        $producto = Producto::where('sku', $row['sku'])->first();
        if ($producto) {
            foreach ($this->asignacion as $asignacion) {
                if (!is_object($asignacion->campo_bd)) {
                    if ($asignacion->campo_bd != 'NO IMPORTAR') {
                        if ($asignacion->campo_bd == 'ultimo_movimiento' || $asignacion->campo_bd == 'ultima_venta' || $asignacion->campo_bd == 'ultima_recepcion') {
                            $producto->{$asignacion->campo_bd} = Carbon::createFromFormat('d/m/Y H:i:s', $row[str_replace(" ", "_", strtolower($asignacion->columna))])->format('Y-m-d H:i:s');
                        } else {
                            $producto->{$asignacion->campo_bd} = $row[str_replace(" ", "_", strtolower($asignacion->columna))];
                        }
                    }
                }
            }
            $producto->save();
            foreach ($this->asignacion as $asignacion) {
                if (is_object($asignacion->campo_bd)) {
                    $inventario = Inventario::where('tienda', $asignacion->campo_bd->id)->where('producto', $producto->id)->first();
                    if ($inventario) {
                        $inventario->cantidad = $row[str_replace(" ", "_", strtolower($asignacion->columna))];
                        $inventario->save();
                    }else{
                        Inventario::create([
                            'tienda' => $asignacion->campo_bd->id,
                            'producto' => $producto->id,
                            'cantidad' => $row[str_replace(" ", "_", strtolower($asignacion->columna))]
                        ]);
                    }
                }
            }
        } else {
            $producto = new Producto();
            foreach ($this->asignacion as $asignacion) {
                if (!is_object($asignacion->campo_bd)) {
                    if ($asignacion->campo_bd != 'NO IMPORTAR') {
                        if ($asignacion->campo_bd == 'ultimo_movimiento' || $asignacion->campo_bd == 'ultima_venta' || $asignacion->campo_bd == 'ultima_recepcion') {
                            $producto->{$asignacion->campo_bd} = Carbon::createFromFormat('d/m/Y H:i:s', $row[str_replace(" ", "_", strtolower($asignacion->columna))])->format('Y-m-d H:i:s');
                        } else {
                            $producto->{$asignacion->campo_bd} = $row[str_replace(" ", "_", strtolower($asignacion->columna))];
                        }
                    }
                }
            }
            $producto->save();
            foreach ($this->asignacion as $asignacion) {
                if (is_object($asignacion->campo_bd)) {
                    Inventario::create([
                        'tienda' => $asignacion->campo_bd->id,
                        'producto' => $producto->id,
                        'cantidad' => $row[str_replace(" ", "_", strtolower($asignacion->columna))]
                    ]);
                }
            }
        }
    }
}
