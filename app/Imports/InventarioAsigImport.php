<?php

namespace App\Imports;

use App\Models\Producto;
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
        if($producto){
            foreach($this->asignacion as $asignacion){
                if($asignacion->campo_bd != 'NO IMPORTAR'){
                    if($asignacion->campo_bd == 'ultimo_movimiento' || $asignacion->campo_bd == 'ultima_venta' || $asignacion->campo_bd == 'ultima_recepcion'){
                        $producto->{$asignacion->campo_bd} = date('Y-m-d H:i:s', strtotime($row[str_replace(" ","_",strtolower($asignacion->columna))]));
                    }else{
                        $producto->{$asignacion->campo_bd} = $row[str_replace(" ","_",strtolower($asignacion->columna))];
                    } 
                }
            }
            $producto->save();
        }else{
            $producto = new Producto();
            foreach($this->asignacion as $asignacion){
                if($asignacion->campo_bd != 'NO IMPORTAR'){
                    if($asignacion->campo_bd == 'ultimo_movimiento' || $asignacion->campo_bd == 'ultima_venta' || $asignacion->campo_bd == 'ultima_recepcion'){
                        $producto->{$asignacion->campo_bd} = date('Y-m-d H:i:s', strtotime($row[str_replace(" ","_",strtolower($asignacion->columna))]));
                    }else{
                        $producto->{$asignacion->campo_bd} = $row[str_replace(" ","_",strtolower($asignacion->columna))];
                    }                  
                }
            }
            $producto->save();
        }

    }
}
