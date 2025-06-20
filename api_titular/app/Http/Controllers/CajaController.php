<?php

namespace App\Http\Controllers;

use App\Models\Caja;
use Illuminate\Http\Request;

class CajaController extends Controller
{
   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      //return Caja::all();
      $model = Caja::orderBy('id','desc')->get();
      $list = [];
      foreach($model as $m){

     
        $list[] = $this->show($m);
      }
      return $list;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Caja  $caja
     * @return \Illuminate\Http\Response
     */
    public function show(Caja $caja)
    {
       
        

        $caja->ventas = $caja->CajaVentas()->where('estado', [1,3])->sum('monto');
        $caja->ventas_detalle = $caja->CajaVentas()->where('estado', [1,3])->get();
   
        //Total de compras por forma de pago
        $caja->compras_efectivo = $caja->CajaCompras()->where('estado', [1,3])->where('forma_pago', 1)->sum('monto');
        $caja->compras_transferencia = $caja->CajaCompras()->where('estado', [1,3])->where('forma_pago', 2)->sum('monto');

      // Total de ventas por forma de pago
    $caja->ventas_efectivo = $caja->CajaVentas()->where('estado', [1,3])->where('forma_pagov', 1)->sum('monto');
    $caja->ventas_transferencia = $caja->CajaVentas()->where('estado', [1,3])->where('forma_pagov', 2)->sum('monto');

        // Movimientos de caja según tipo de pago
        $movimientos_efectivo = $caja->CajaMovimientos()->where('tipo', 1)->where('pago', 5)->sum('monto');
        $movimientos_transferencia = $caja->CajaMovimientos()->where('tipo', 1)->where('pago', 3)->sum('monto');

        $salidas_efectivo = $caja->CajaMovimientos()->where('tipo', 2)->where('pago', 5)->sum('monto');
        $salidas_transferencia = $caja->CajaMovimientos()->where('tipo', 2)->where('pago', 3)->sum('monto');


        // Total efectivo = ventas + ingresos manuales - compras - salidas manuales
        $caja->total_efectivo = floatval(
          $caja->ventas_efectivo + $movimientos_efectivo - $caja->compras_efectivo - $salidas_efectivo
        );
                
        // Total transferencia = ventas + ingresos manuales - compras - salidas manuales
        $caja->total_transferencia = floatval(
          $caja->ventas_transferencia + $movimientos_transferencia - $caja->compras_transferencia - $salidas_transferencia
        );

        $caja->compras = $caja->CajaCompras()->where('estado', [1,3])->sum('monto');
        $caja->compras_detalle = $caja->CajaCompras()->where('estado', [1,3])->get();
        $caja->movimientos = $caja->CajaMovimientos()->get();
        $caja->ingresos =  $caja->movimientos->where('tipo',1)->sum('monto');
        $caja->salidas =  $caja->movimientos->where('tipo',2)->sum('monto');
        $caja->total = floatval($caja->ingresos + $caja->ventas - $caja->salidas - $caja->compras);
        //caja->totalcaja = $caja->total;
        $caja->user = $caja->User;
    
        $caja->fecha = $caja->created_at->format('d-m-y');
        foreach ($caja->compras_detalle as $compra) {
            $compra->factur = $compra->factur;
        }
   
        //
        return $caja;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Caja  $caja
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Caja $caja)
    {
      // Cerrar la caja actual
      $caja->estado = 0;
      $caja->estadocaja = 0;
      $caja->save();
  
      // Crear nueva caja (cerrada por defecto pero activa)
      $newCaja = new Caja();
      $newCaja->user_id = $caja->user_id;
      $newCaja->estado = 1;
      $newCaja->estadocaja = 0; // aún cerrada para operar
      $newCaja->save();
  
      return $newCaja;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Caja  $caja
     * @return \Illuminate\Http\Response
     */
    public function destroy(Caja $caja)
    {
        //
    }
    public function abrirCaja(Request $request, $id)
{
    $caja = Caja::findOrFail($id);
    $caja->forceFill(['estadocaja' => 1])->save();
    $caja->save();

    return response()->json([
        'message' => 'Caja habilitada para operaciones',
        'caja' => $caja
    ]);
}

}

