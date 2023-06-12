<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\ItemsEncomenda;

class Cores extends Model
{
    use HasFactory;
    protected $table = 'colors';
    protected $primaryKey  = 'code';
    public $incrementing = false;
    protected $keyType = 'string';

    public function itemsEncomenda(): HasMany{
        return $this->hasMany(ItemsEncomenda::class, 'color_code', 'id');
    }
}
