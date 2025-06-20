<?php

namespace App\Http\Controllers;
use App\Models\Articulo;
use App\Models\User;
use App\Models\Venta;
use App\Models\Compra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
 public function info()
{
    $fechaLimite = now()->subMonths(3);

    return [
        "articulos" => Articulo::where('estado', 1)->count(),
        "usuarios" => User::where('estado', 1)->count(),

        // SOLO los últimos 3 meses
        "compras" => Venta::where('estado', 1)
                          ->where('created_at', '>=', $fechaLimite)
                          ->sum('total'),

        "ventas" => Compra::where('estado', 1)
                          ->where('created_at', '>=', $fechaLimite)
                          ->sum('total'),

        "meses" => $this->VentasMensual($fechaLimite),
        "mas_vendidos" => $this->masVendidos($fechaLimite),
        "criticos_vendidos" => $this->articulosCriticosVendidos(),
        
         "proveedores_clientes" => [
            "proveedores" => \App\Models\Proveedor::where('estado', 1)->count(),
            "clientes" => \App\Models\Cliente::where('estado', 1)->count()
        ]
    ];
}

public function VentasMensual() {
    return Venta::select(
            DB::raw('SUM(total) as total'),
            DB::raw("DATE_FORMAT(created_at,'%M %Y') as mes"),
            DB::raw("MAX(created_at) as fecha_max")
        )
        ->where('estado', 1)
        ->groupBy('mes')
        ->orderByDesc('fecha_max') // ordena por fecha real
        ->limit(3)
        ->get()
        ->sortBy('fecha_max') // para mostrar en orden cronológico
        ->values();
}

   public function masVendidos(){
    $fechaLimite = now()->subMonths(3);

    $articulos = \App\Models\Inventario::select('articulo_id', DB::raw('SUM(cantidad) as total_vendido'))
        ->where('tipo', 2) // tipo 2 = salida/venta
        ->where('created_at', '>=', $fechaLimite)
        ->groupBy('articulo_id')
        ->orderByDesc('total_vendido')
        ->take(5)
        ->with('Articulo:id,nombre')
        ->get()
        ->map(function ($i) {
            return [
                'id' => $i->articulo_id,
                'nombre' => $i->Articulo->nombre ?? 'Sin nombre',
                'cantidad' => $i->total_vendido
            ];
        });

    return $articulos;
}

public function articulosCriticosVendidos()
{
    $fechaLimite = now()->subMonths(3);

    $articulos = \App\Models\Inventario::select('articulo_id', DB::raw('SUM(cantidad) as total_vendido'))
        ->where('tipo', 2) // salida/venta
        ->where('created_at', '>=', $fechaLimite)
        ->groupBy('articulo_id')
        ->orderByDesc('total_vendido')
        ->with(['Articulo' => function ($q) {
            $q->select('id', 'nombre', 'stock_minimo');
        }])
        ->get()
        ->filter(function ($i) {
            $ingresos = \App\Models\Inventario::where('articulo_id', $i->articulo_id)->where('tipo', 1)->sum('cantidad');
            $egresos = \App\Models\Inventario::where('articulo_id', $i->articulo_id)->where('tipo', 2)->sum('cantidad');
            $stock_actual = $ingresos - $egresos;
            return $stock_actual <= optional($i->Articulo)->stock_minimo;
        })
        ->take(7)
        ->map(function ($i) {
            return [
                'id' => $i->articulo_id,
                'nombre' => $i->Articulo->nombre ?? 'Sin nombre',
                'cantidad' => $i->total_vendido
            ];
        });

    return $articulos;
}

public function proveedoresVsClientes()
{
    return [
        'proveedores' => Proveedor::where('estado', 1)->count(),
        'clientes' => Cliente::where('estado', 1)->count()
    ];
}

}
