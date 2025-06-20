<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    use HasFactory;
    public function Tipo(){
        return $this->belongsTo(Tipo::class);
    }
    public function Distrito(){
        return $this->belongsTo(Distrito::class);
    }
    public function Persona(){
        return $this->belongsTo(Persona::class);
    }
}
