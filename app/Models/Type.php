<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    // protected $table = 'money-types'; //este comando es para especificar que este modelo representa una tabla x (por lo general deberia de tomar una tabla que contenga su nombre pero en plural)
    protected $fillable = ['name', 'relacion_mn'];//los campos que se van a permitir manipular de forma masiva
    
    //protected $rules = ['description' => 'required|max:5'];//regla de validacion para la tabla modelo
    
    // use HasFactory;
}
