<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Precos extends Model
{
    use HasFactory;
    protected $table = 'prices';
    public $timestamps = false; 

    protected $fillable = [
        'unit_price_catalog',
        'unit_price_catalog_discount',
        'unit_price_own',
        'unit_price_own_discount',
        'qty_discount', 
    ];

    // pk é id (incrementavel) inteiro - nao tem created_at e updated_at
}
