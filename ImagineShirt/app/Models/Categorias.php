<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\TShirts;
use Illuminate\Database\Eloquent\SoftDeletes;

class Categorias extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'categories';
    public $timestamps = false;
    // pk é id (incrementavel) inteiro - tem deleted_at

    public function tshirts(): HasMany{
        return $this->hasMany(TShirts::class, 'category_id', 'id');
    }

    
}
