<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alquiler extends Model
{
    use HasFactory;
    protected $table = "alquileres";

    //relacion de 1:N con DetalleAlquiler
    public function detalle_alquileres(){
        return $this->hasMany(DetalleAlquiler::class);
    }

    //relacion inversa con el user(cuando el cliente hace la reserva)
    public function user(){
        return $this->belongsTo(User::class);
    }
}
