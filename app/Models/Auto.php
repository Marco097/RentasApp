<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Auto extends Model
{
    use HasFactory;

    //definiendo relaciones inversas
    public function marca(){
        return $this->belongsTo(Marca::class);
    }

    public function modelo(){
        return $this->belongsTo(Modelo::class);
    }

    //relacion de 1:N con el modelo DetalleAlquiler
    public function detalle_alquileres(){
        return $this->HasMany(DetalleAlquiler::class);
    }
}
