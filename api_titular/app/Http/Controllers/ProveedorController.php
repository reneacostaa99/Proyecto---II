<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use Illuminate\Http\Request;

class ProveedorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Proveedor::with(['Tipo','Persona','Distrito'])->where('estado',1)->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $proveedor = new Proveedor();
        $proveedor->tipo_id = $request->tipo_id;
        $proveedor->nombre = $request->nombre;
        $proveedor->apellido = $request->apellido;
        $proveedor->direccion = $request->direccion;
        $proveedor->distrito_id = $request->distrito_id;
        $proveedor->telefono = $request->telefono;
        $proveedor->celular = $request->celular;
        $proveedor->nro_ruc = $request->nro_ruc;
        $proveedor->nro_ci = $request->nro_ci;
        $proveedor->correo = $request->correo;
        $proveedor->persona_id = $request->persona_id;
        $proveedor->save();
        return $proveedor;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Proveedor  $proveedor
     * @return \Illuminate\Http\Response
     */
    public function show(Proveedor $proveedor)
    {
        $proveedor->tipo = $proveedor->Tipo;
        $proveedor->persona = $proveedor->Persona;
        $proveedor->distrito = $proveedor->Distrito;
        return $proveedor;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Proveedor  $proveedor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Proveedor $proveedor)
    {
        $proveedor->tipo_id = $request->tipo_id;
        $proveedor->nombre = $request->nombre;
        $proveedor->apellido = $request->apellido;
        $proveedor->direccion = $request->direccion;
        $proveedor->distrito_id = $request->distrito_id;
        $proveedor->telefono = $request->telefono;
        $proveedor->celular = $request->celular;
        $proveedor->nro_ruc = $request->nro_ruc;
        $proveedor->nro_ci = $request->nro_ci;
        $proveedor->correo = $request->correo;
        $proveedor->persona_id = $request->persona_id;
        $proveedor->save();
        return $proveedor;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Proveedor  $proveedor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Proveedor $proveedor)
    {
        $proveedor->estado = 0;
        $proveedor->save();
    }
}
