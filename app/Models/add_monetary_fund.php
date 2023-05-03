<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class add_monetary_fund extends Model
{
    protected $fillable = ['monetary_value', 'branch_id', 'type_id'];
    // use HasFactory;
}
