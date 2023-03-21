<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modelo extends Model
{
    use HasFactory;

    //ralacion de 1:N con autos 
    public function autos(){
        return $this->hasMany(Auto::class);
   }
}
