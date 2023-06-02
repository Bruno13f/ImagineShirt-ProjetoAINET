<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Precos extends Model
{
    use HasFactory;
    protected $table = 'prices';
    public $timestamps = false; 
    // pk é id (incrementavel) inteiro - nao tem created_at e updated_at
}
