<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CajaCompra extends Model
{
    public function caja()
    {
        return $this->belongsTo(Caja::class);
    }

    public function compra()
    {
        return $this->belongsTo(Compra::class);
    }
    use HasFactory;
}
