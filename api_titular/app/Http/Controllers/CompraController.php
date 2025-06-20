<?php

namespace App\Http\Controllers;

use App\Models\Compra;
use App\Models\Caja;
use App\Models\CajaCompra;
use App\Models\CompraInventario;
use App\Models\Inventario;
use Illuminate\Http\Request;

class CompraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $compras = Compra::whereIn('estado', [1, 3])
                        ->get()
                        ->sortByDesc('created_at') // Ordenar por fecha de creación descendente
                        ->values(); // Reindexar el arreglo para tener índices secuenciales
        
        $list = [];
        
        foreach ($compras as $compra) {
            $list[] = $this->show($compra);
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
        
         //seccion de la compra en el modulo de caja del fronted
         $caja = Caja::find($request->caja_id);

         if (!$caja || $caja->estadocaja == 0) {
             return response()->json(['error' => 'No se puede realizar la compra. La caja está cerrada.'], 403);
         }
         
        $fecha = $request->input('fecha');

        $compra = new Compra();
        $compra->total = $request->total;
        $compra->tipo = $request->tipo;
        $compra->proveedor_id = $request->proveedor_id;
        $compra->factura = $request->factura;
        $compra->timbrado = $request->timbrado;
        $compra->motivo = $request->motivo;
        $compra->fecha = $request->fecha; 
        $compra->tipo_compra = $request->tipo_compra; 
        $compra->estado = 3; 
        $compra->forma_pago = $request->forma_pago;
        $compra->save();

        
        //seccion de la compra en el modulo de caja del fronted
        $CajaCompra = new CajaCompra();
        $CajaCompra->caja_id = $request->caja_id;
        $CajaCompra->compra_id = $compra->id;
        $CajaCompra->monto = $request->total;
        $CajaCompra->estado = $compra->estado;
        $CajaCompra->factur = $compra->timbrado;
        $CajaCompra->forma_pago = $compra->forma_pago;
        $CajaCompra-> save();
        //
        $numero = Compra::all()->count()+1;
        if(isset($request->carrito)){
            if(!empty($request->carrito)){
                foreach($request->carrito as $m){
                    $articulo = $m['articulo'];
                    $inventario = new Inventario();
                    $inventario->articulo_id = $articulo['id'];
                    $inventario->tipo = 1;
                    $inventario->compra = $articulo['compra'];
                    $inventario->venta = $articulo['venta'];
                    $inventario->cantidad = $m['cantidad'];
                    $inventario->motivo = "COMPRA #".$numero;
                    $inventario->save();
                    $compraInventario = new CompraInventario();
                    $compraInventario->inventario_id = $inventario->id;
                    $compraInventario->compra_id = $compra->id;
                    $compraInventario->cantidad = $m['cantidad'];
                    $compraInventario->precio = $m['precio'];
                    $compraInventario->save();
                }
            }
        }
        return $compra;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Compra  $compra
     * @return \Illuminate\Http\Response
     */
    public function show(Compra $compra)
{

         // Calcular el total de compras de acuerdo a la forma de pago
         $compra->compras_efectivo = $compra->CajaCompra()
         ->where('estado', [1, 3])
         ->where('forma_pago', 1)
         ->sum('monto');
     $compra->compras_transferencia = $compra->CajaCompra()
              ->where('estado', [1, 3])
              ->where('forma_pago', 2)
              ->sum('monto');
             

    // Detalles de inventario y relación con otros modelos
    $compra->compra_inventarios = $compra->CompraInventarios()->with(['Inventario' => function ($i) {
        $i->with(['Articulo' => function ($a) {
            $a->with(['Marca', 'Categoria', 'Medida']);
        }]);
    }])->get();

    // Formatear la fecha de la compra
    $compra->fecha = $compra->created_at->format('d-m-y');

    // Relación con el proveedor
    $compra->proveedor = $compra->Proveedor;

    // Agregar el número de factura (si existe en el modelo 'Compra')
    // Asumiendo que 'factura' ya está presente en el modelo 'Compra'
    
    return $compra;
}

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Compra  $compra
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Compra $compra)
    {
        if ($request->has('estado')) {
            $compra->estado = $request->estado;
            $compra->save();
            $cajaCompra = $compra->CajaCompra;
        $cajaCompra->estado = 1;
        $cajaCompra->save();
        }
        return response()->json($compra, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Compra  $compra
     * @return \Illuminate\Http\Response
     */
    public function destroy(Compra $compra)
    {
        $compra->estado =0;
        $compra->save();
    }
}
