<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Weight extends Model
{
    protected $fillable = ['name', 'relacion_lb'];
    // use HasFactory;
}
