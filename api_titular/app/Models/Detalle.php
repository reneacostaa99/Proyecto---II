<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detalle extends Model
{
    use HasFactory;
    public function Cabecera(){
        return $this->belongsTo(Cabecera::class);
    }
    public function Articulo(){
        return $this->belongsTo(Articulo::class);
    }
    public function Venta(){
        return $this->belongsTo(Venta::class);
    }

}
