<?php

namespace App\Imports;

use App\Models\Venta;
use App\Models\tienda;
use App\Models\Cliente;
use App\Models\Producto;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class VentasImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function model(array $row)
    {
        //cambios
        $date = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['fecha'])->format('Y-m-d');
        $tienda = tienda::where('tienda', $row['tienda'])->first();
        $cliente = Cliente::where('identificacion', $row['identificacion'])->first();
        $producto = Producto::where('sku', $row['sku'])->first();
        
        if ($tienda == null) $tienda = Tienda::create(['nombre' => $row['tienda'], 'ciudad'=>$row['ciudad']]);        
        if ($cliente == null) {
            $cliente = Cliente::create([
                'identificacion' => $row['identificacion'],
                'nombres' => $row['cliente'],
                'genero' => $row['genero'],
                'correo' => $row['correo'],
                'telefono' => $row['telefono'],
                // 'telefono2' => $row['telefono2'],
                'direccion' => $row['direccion'],
                'fecha_nacimiento' => $row['fecha_nac']
            ]);
        }
        if ($producto == null) {
            $producto = Producto::create([
                'sku' => $row['sku'],
                'externo' => $row['codigo'],
                'producto' => $row['producto'],
                'estilo' => $row['estilo'],
                'color' => $row['color'],
                'talla' => $row['talla'],
                'marca' => $row['marca'],
                'grupo' => $row['grupo'],
                'seccion' => $row['seccion'],
            ]);
        }

        $venta = Venta::where('transaccion', $row['transaccion'])->first();

        if ($venta == null){
            Venta::create([
                'tienda_id' => $tienda->id,
                'cliente_id' => $cliente->id,
                'division' => $row['division'],
                'departamento' => $row['departamento'],
                'producto_id' => $producto->id,
                'descuento_actual' => $row['desc_actual'],
                'pvp_factura' => $row['pvp_factura'],
                'pvp' => $row['pvp'],
                'pvp_mayorista' => $row['pvp_mayorista'],
                'punto_operacion' => $row['punto_operacion'],
                'fecha' => $date,
                'hora' => $row['hora_minuto'],
                'vendedor' => $row['vendedor'],
                'cajero' => $row['cajero'],
                'tipo' => $row['tipo'],
                'transaccion' => $row['transaccion'],
                'cantidad' => $row['cantidad'],
                'costo' => $row['costo'],
                'subtotal' => $row['subtotal'],
                'por_descuento_manual' => $row['por_desc_manual'],
                'por_descuento_sistema' => $row['por_desc_sistema'],
                'por_descuento' => $row['por_desc'],
                'descuento_manual' => $row['desc_manual'],
                'descuento_sistema' => $row['desc_sistema'],
                'descuento' => $row['descuento'],
                'venta_neta' => $row['venta_neta'],
                'impuesto' => $row['impuestos'],
                'total' => $row['total'],
                'utilidad' => $row['utilidad'],
                'gm' => $row['gm'],
                'efectivo' => $row['efectivo'],
                'tarjeta_credito' => $row['tcredito'],
                'tarjeta_debito' => $row['tdebito'],
                'nota_credito' => $row['ncredito'],
                'cupo_credito' => $row['cupo_credito'],
                'cheque' => $row['cheque'],
                'otros' => $row['otros'],
                'devolucion' => $row['devoluciones'],
                'medianet' => $row['medianet'],
                'datafast' => $row['datafast'],
                'austro' => $row['austro'],
                'visa' => $row['visa'],
                'mastercard' => $row['mastercard'],
                'american_express' => $row['american_express'],
                'diners' => $row['diners'],
                'discovery' => $row['discover'],
                'pacificard' => $row['pacificard'],
                'bankcard' => $row['bankcard'],
                'alia' => $row['alia'],
                'otras_tarjetas' => $row['otras_tarjetas'],
                'banco_pichincha' => $row['bco_del_pichincha'],
                'banco_pacifico' => $row['bco_del_pacifico'],
                'banco_guayaquil' => $row['bco_guayaquil'],
                'banco_bolivariano' => $row['bco_bolivariano'],
                'banco_produbanco' => $row['bco_produbanco'],
                'banco_austro' => $row['bco_del_austro'],
                'banco_internacional' => $row['bco_internacional'],
                'banco_solidario' => $row['bco_solidario'],
                'banco_machala' => $row['bco_de_machala'],
                'otros_bancos' => $row['otros_bancos'],
            ]);
        }else{
            $venta->update([
                'tienda_id' => $tienda->id,
                'cliente_id' => $cliente->id,
                'division' => $row['division'],
                'departamento' => $row['departamento'],
                'producto_id' => $producto->id,
                'descuento_actual' => $row['desc_actual'],
                'pvp_factura' => $row['pvp_factura'],
                'pvp' => $row['pvp'],
                'pvp_mayorista' => $row['pvp_mayorista'],
                'punto_operacion' => $row['punto_operacion'],
                'fecha' => $date,
                'hora' => $row['hora_minuto'],
                'vendedor' => $row['vendedor'],
                'cajero' => $row['cajero'],
                'tipo' => $row['tipo'],
                'transaccion' => $row['transaccion'],
                'cantidad' => $row['cantidad'],
                'costo' => $row['costo'],
                'subtotal' => $row['subtotal'],
                'descuento_manual' => $row['desc_manual'],
                'descuento_sistema' => $row['desc_sistema'],
                'descuento' => $row['descuento'],
                'venta_neta' => $row['venta_neta'],
                'impuesto' => $row['impuestos'],
                'total' => $row['total'],
                'utilidad' => $row['utilidad'],
                'gm' => $row['gm'],
                'efectivo' => $row['efectivo'],
                'tarjeta_credito' => $row['tcredito'],
                'tarjeta_debito' => $row['tdebito'],
                'nota_credito' => $row['ncredito'],
                'cupo_credito' => $row['cupo_credito'],
                'cheque' => $row['cheque'],
                'otros' => $row['otros'],
                'devolucion' => $row['devoluciones'],
                'medianet' => $row['medianet'],
                'datafast' => $row['datafast'],
                'austro' => $row['austro'],
                'visa' => $row['visa'],
                'mastercard' => $row['mastercard'],
                'american_express' => $row['american_express'],
                'diners' => $row['diners'],
                'discovery' => $row['discover'],
                'pacificard' => $row['pacificard'],
                'bankcard' => $row['bankcard'],
                'alia' => $row['alia'],
                'otras_tarjetas' => $row['otras_tarjetas'],
                'banco_pichincha' => $row['bco_del_pichincha'],
                'banco_pacifico' => $row['bco_del_pacifico'],
                'banco_guayaquil' => $row['bco_guayaquil'],
                'banco_bolivariano' => $row['bco_bolivariano'],
                'banco_produbanco' => $row['bco_produbanco'],
                'banco_austro' => $row['bco_del_austro'],
                'banco_internacional' => $row['bco_internacional'],
                'banco_solidario' => $row['bco_solidario'],
                'banco_machala' => $row['bco_de_machala'],
                'otros_bancos' => $row['otros_bancos'],
            ]);
        }
    }
}
