<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Cliente::with(['Tipo','Persona','Distrito'])->where('estado',1)->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cliente = new Cliente();
        $cliente->tipo_id = $request->tipo_id;
        $cliente->nombre = $request->nombre;
        $cliente->apellido = $request->apellido;
        $cliente->direccion = $request->direccion;
        $cliente->distrito_id = $request->distrito_id;
        $cliente->telefono = $request->telefono;
        $cliente->celular = $request->celular;
        $cliente->nro_ruc = $request->nro_ruc;
        $cliente->nro_ci = $request->nro_ci;
        $cliente->correo = $request->correo;
        $cliente->persona_id = $request->persona_id;
        $cliente->save();
        return $cliente;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function show(Cliente $cliente)
    {
        $cliente->tipo = $cliente->Tipo;
        $cliente->persona = $cliente->Persona;
        $cliente->distrito = $cliente->Distrito;
        return $cliente;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cliente $cliente)
    {
        $cliente->tipo_id = $request->tipo_id;
        $cliente->nombre = $request->nombre;
        $cliente->apellido = $request->apellido;
        $cliente->direccion = $request->direccion;
        $cliente->distrito_id = $request->distrito_id;
        $cliente->telefono = $request->telefono;
        $cliente->celular = $request->celular;
        $cliente->nro_ruc = $request->nro_ruc;
        $cliente->nro_ci = $request->nro_ci;
        $cliente->correo = $request->correo;
        $cliente->persona_id = $request->persona_id;
        $cliente->save();
        return $cliente;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cliente $cliente)
    {
        $cliente->estado = 0;
        $cliente->save();
    }
}
