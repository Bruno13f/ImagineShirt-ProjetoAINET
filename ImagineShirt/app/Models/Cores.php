<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\ItensEncomenda;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cores extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'colors';
    protected $primaryKey  = 'code';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    public function itensEncomenda(): HasMany{
        return $this->hasMany(ItensEncomenda::class, 'color_code', 'code');
    }
}
