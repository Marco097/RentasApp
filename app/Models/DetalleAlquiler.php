<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetalleAlquiler extends Model
{
    use HasFactory;
    protected $table = "detalle_alquileres";

    //relaciones inversas
    public function autos(){
        return $this->belongsTo(Auto::class);
    }

    public function alquileres(){
        return $this->belongsTo(Alquiler::class); 
    }
}
