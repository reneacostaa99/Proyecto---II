<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Factura</title>
  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; font-family: Arial, sans-serif; }
    .ticket { width: 190mm; max-width: 150mm; margin: auto; padding: 10px; border: 1px solid #333; }
    table { width: 100%; border-collapse: collapse; font-size: 14px; margin-bottom: 8px; }
    th, td { padding: 4px; }
    .bold { font-weight: bold; }
    .text-center { text-align: center; }
    .text-left { text-align: left; }
    .text-right { text-align: right; }
    .border-top { border-top: 1px solid #000; }
    .border-bottom { border-bottom: 1px solid #000; }
    @media print {
      .ticket { border: none; }
    }
  </style>
</head>
<body>
  <div class="ticket">
    <table>
      <tr><td colspan="2" class="text-left bold" style="font-size:18px;">M & C Electronica</td></tr>
      <tr><td colspan="2" class="text-left">San Lorenzo-Paraguay</td></tr>
      <tr><td class="text-left">RUC:  803346-3</td><td class="text-right bold">NRO. DE FACTURA <br>001-001-000{{$venta->factura}}</td></tr>
      <tr><td colspan="2">TIMBRADO N°{{$venta->timbrado}}<br>INICIO DE VIGENCIA: 30-01-2025<br>FIN DE VIGENCIA: 30-01-2026</td></tr>
    </table>

    <table class="border-top border-bottom">
      <tr>
        <td class="text-left"><strong>FECHA DE EMISIÓN:</strong> {{$venta->fecha}}</td>
        <td class="text-right"><strong>CONDICIÓN DE VENTA:</strong> CONTADO</td>
      </tr>
      <tr>
        <td colspan="2" class="text-left"><strong>RUC / C.I.:</strong>{{$venta->cliente->nro_ruc}}</td>
      </tr>
      <tr>
        <td colspan="2" class="text-left"><strong>CLIENTE: </strong>{{$venta->cliente->nombre}} {{$venta->cliente->apellido}}</td>
      </tr>
    </table>

    <table class="border-top border-bottom">
      <tr class="bold">
        <th class="text-left">ARTICULO</th>
        <th class="text-left">CANT</th>
        <th class="text-right">PRECIO UN</th>
        <th class="text-right">TOTAL</th>
        <th class="text-right">IVA</th>
      </tr>
      <?php foreach ($venta->venta_inventarios as $d) { ?>
      <tr>
      <td class="text-left">{{$d->inventario->articulo->nombre}}</td>
        <td class="text-left">{{$d->cantidad}}</td>
        <td class="text-right">{{ number_format($d->precio, 0, ',', '.') }} Gs.</td>
        <td class="text-right">{{ number_format($d->precio * $d->cantidad, 0, ',', '.') }} Gs.</td>
        <td class="text-right">10%</td>
      </tr>
      <?php } ?>
    </table>

    <table>
      <tr>
        <td class="text-left bold">Total a Pagar:</td>
        <td class="text-right">{{ number_format($venta->total, 0, ',', '.') }}</td>
      </tr>
    </table>

    <table class="border-top">
      <tr>
        <td class="text-left">Liquidación del IVA 5%:</td>
        <td class="text-right">0 Gs.</td>
      </tr>
      <tr>
        <td class="text-left">Liquidación del IVA 10%:</td>
        <td class="text-right">{{ number_format($venta->total / 11, 0, ',', '.' ) }} Gs.</td>
      </tr>
      <tr>
        <td class="text-left bold">Total IVA:</td>
        <td class="text-right bold">{{ number_format($venta->total / 11, 0, ',', '.' ) }} Gs.</td>
      </tr>
    </table>
  </div>
</body>
</html>
