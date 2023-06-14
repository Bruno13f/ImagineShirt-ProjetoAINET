<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\ItensEncomenda;

class Cores extends Model
{
    use HasFactory;
    protected $table = 'colors';
    protected $primaryKey  = 'code';
    protected $keyType = 'string';
    public $incrementing = false;

    public function itemsEncomenda(): HasMany{
        return $this->hasMany(ItensEncomenda::class, 'color_code', 'id');
    }
}
