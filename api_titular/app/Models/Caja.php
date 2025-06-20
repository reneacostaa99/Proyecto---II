<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Caja extends Model
{


 
    use HasFactory;

    // Agrega 'totalcaja' aquí
    protected $fillable = [
        'user_id',
        'estado',
        'totalcaja',
        'estadocaja',
        // otros campos que necesites...
    ];
    public function User(){
        return $this->belongsTo(User::class);
    }
    public function CajaVentas(){
        return $this->hasMany(CajaVenta::class)->where('estado',1);
    }
    public function CajaCompras(){
        return $this->hasMany(CajaCompra::class);
    }
    public function CajaMovimientos(){
        return $this->hasMany(CajaMovimiento::class);
    }
 
}
