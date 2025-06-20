<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\Caja;
use App\Models\CajaVenta;
use App\Models\VentaInventario;
use App\Models\Inventario;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class VentaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /*$venta = Venta::estadoUnoYTres()->get();
        $list = [];
        foreach ($venta as $m) {
            $list[] = $this->show($m);
        //}
        //return $list;*/

        $ventas = Venta::whereIn('estado', [1, 3])
        ->get()
        ->sortByDesc('created_at') // Ordenar por fecha de creación descendente
        ->values(); // Reindexar el arreglo para tener índices secuenciales

$list = [];

foreach ($ventas as $ventas) {
$list[] = $this->show($ventas);
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
        
         //seccion de la validacion del id caja en el modulo de ventas del fronted
        $caja = Caja::find($request->caja_id);

        if (!$caja || $caja->estadocaja == 0) {
            return response()->json(['error' => 'No se puede realizar la venta. La caja está cerrada.'], 403);
        }

        $venta = new Venta();
        $venta->total = $request->total;
        $venta->pago = $request->pago;
        $venta->cambio = $request->cambio;
        $venta->factura = $request->factura;
        $venta->timbrado = $request->timbrado;
        $venta->tipo = $request->tipo;
        $venta->cliente_id = $request->cliente_id;
        $venta->motivo = $request->motivo;
        $venta->estado = 3;
        $venta->forma_pagov = $request->forma_pagov;
        $venta->saveOrFail();
        
        $numero = Venta::all()->count() + 1;
        
        if (isset($request->carrito) && !empty($request->carrito)) {
            foreach ($request->carrito as $m) {
                $articulo = $m['articulo'];
                $inventario = new Inventario();
                $inventario->articulo_id = $articulo['id'];
                $inventario->tipo = 2;
                $inventario->compra = $articulo['compra'];
                $inventario->venta = $articulo['venta'];
                $inventario->cantidad = $m['cantidad'];
                $inventario->motivo = "Venta #" . $numero;
                $inventario->save();

                $ventaInventario = new VentaInventario();
                $ventaInventario->inventario_id = $inventario->id;
                $ventaInventario->venta_id = $venta->id;
                $ventaInventario->cantidad = $m['cantidad'];
                $ventaInventario->precio = $m['precio'];

                $ventaInventario->save();
            }
        }
        
        if (isset($request->caja_id)) {
            $cajaVenta = new CajaVenta();
            $cajaVenta->caja_id = $request->caja_id;
            $cajaVenta->venta_id = $venta->id;
            $cajaVenta->monto = $venta->total;
            $cajaVenta->estado = $venta->estado;
            $cajaVenta->factu = $venta->factura;
            $cajaVenta->forma_pagov = $venta->forma_pagov;
            $cajaVenta->save();
        }

        return $this->show($venta);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Venta  $venta
     * @return \Illuminate\Http\Response
     */
    public function show(Venta $venta)
    {
        $venta->venta_inventarios = $venta->VentaInventarios()->with(['Inventario' => function ($i) {
            $i->with(['Articulo' => function ($a) {
                $a->with(['Marca', 'Categoria', 'Medida']);
            }]);
        }])->get();
        $venta->fecha = $venta->created_at->format('d-m-y');
        $venta->cliente = $venta->Cliente;
        $venta->url_pdf = url('api/reportes/ventas/' . $venta->id);
        return $venta;
    }

    public function pdf(Venta $venta)
    {
        $venta = $this->show($venta);
        $pdf = PDF::loadView('reports.venta', ["venta" => $venta]);        
        return $pdf->stream();
    }


    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Venta  $venta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Venta $venta)
    {
        if ($request->has('estado')) {
            $venta->estado = $request->estado;
            $venta->save();
            $cajaVenta = $venta->CajaVenta;
        $cajaVenta->estado = 1;
        $cajaVenta->save();
        }
        return response()->json($venta, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Venta  $venta
     * @return \Illuminate\Http\Response
     */
    public function destroy(Venta $venta)
    {
        $venta->estado = 0;
        $venta->save();
        
        $cajaVenta = $venta->CajaVenta;
        $cajaVenta->estado = 0;
        $cajaVenta->save();
    }
}
