<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mov extends Model
{
    // use HasFactory;
    protected $fillable = ['mov_type', 'id_prod', 'cant', 'weight_id', 'sales_price', 'type_id', 'branch_id'];
}
