<?php

namespace App\Http\Controllers;

use App\Models\tienda;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Http\Request;

class TiendasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return tienda::VuePaginate();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'tienda' => 'required',
        ]);

        Tienda::create($request->all());

        return response()->json([
            'message' => 'Tienda creada correctamente'
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
        $tienda = Tienda::findOrFail($id);
        return $tienda;        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $tienda = Tienda::findOrFail($id);
        $tienda->update($request->all());

        return response()->json([
            'message' => 'Tienda actualizada correctamente'
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
        $tienda = Tienda::findOrFail($id);
        $tienda->estado = 0;
        $tienda->save();
        return response()->json([
            'message' => 'Tienda eliminada correctamente'
        ], 200);
    }
}
