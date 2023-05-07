<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class merma extends Model
{
    // use HasFactory;
    protected $fillable = ['description', 'cant', 'weights_id', 'product_id'];
}
