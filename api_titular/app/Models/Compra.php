<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    
    use HasFactory;
    use HasFactory;

    protected $fillable = ['caja_id', 'monto', 'factur', 'estado'];

    public function Caja()
    {
        return $this->belongsTo(Caja::class);
    }
    
    public function CompraInventarios(){
        return $this->hasMany(CompraInventario::class);
    }
    public function Proveedor(){
        return $this->belongsTo(Proveedor::class);
    }
    public function CajaCompra(){
        return $this->hasOne(CajaCompra::class);
    }
    public function CajaVenta(){
        return $this->hasOne(CajaVenta::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id1');
    }
    
    public function CajaVentas(){
        return $this->hasMany(CajaVenta::class)->where('estado',1);
    }
    public function CajaMovimientos(){
        return $this->hasMany(CajaMovimiento::class);
    }
    
}
