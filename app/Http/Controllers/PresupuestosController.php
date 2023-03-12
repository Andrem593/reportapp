<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Presupuesto;
use Illuminate\Http\Request;

class PresupuestosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fecha = Carbon::now()->format('Y-m-d');

        $presupuestos = Presupuesto::with('tienda')
            ->where('fecha_inicio', '<=', $fecha)
            ->where('fecha_fin', '>=', $fecha)
            ->where('estado', '=', 1)
            ->get();

        return $presupuestos;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'tienda_id' => 'required',
                'presupuesto' => 'required',
                'fecha_inicio' => 'required',
                'fecha_fin' => 'required',
            ]
        );

        Presupuesto::create([
            'tienda_id' => $request->tienda_id,
            'presupuesto' => $request->presupuesto,
            'fecha_inicio' => Carbon::parse($request->fecha_inicio)->format('Y-m-d'),
            'fecha_fin' => Carbon::parse($request->fecha_fin)->format('Y-m-d'),
        ]);

        return response()->json([
            'message' => 'Presupuesto creado correctamente'
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Presupuesto::with('tienda')->find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return Presupuesto::with('tienda')->find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate(
            [                
                'tienda_id' => 'required',
                'presupuesto' => 'required',
                'fecha_inicio' => 'required',
                'fecha_fin' => 'required',
            ]
        );

        $presupuesto = Presupuesto::find($id);
        $presupuesto->tienda_id = $request->tienda_id;
        $presupuesto->presupuesto = $request->presupuesto;
        $presupuesto->fecha_inicio = Carbon::parse($request->fecha_inicio)->format('Y-m-d');
        $presupuesto->fecha_fin = Carbon::parse($request->fecha_fin)->format('Y-m-d');
        $presupuesto->save();

        return response()->json([
            'message' => 'Presupuesto actualizado correctamente'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $presupuesto = Presupuesto::find($id);
        $presupuesto->estado = 0;
        $presupuesto->save();

        return response()->json([
            'message' => 'Presupuesto eliminado correctamente'
        ], 200);
    }
}
