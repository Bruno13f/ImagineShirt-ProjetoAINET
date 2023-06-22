<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Categorias;
use Illuminate\Support\Str;
use App\Models\ItensEncomenda;
use Illuminate\Database\Eloquent\SoftDeletes;

class TShirts extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'tshirt_images';
    // pk é id (incrementavel) inteiro - tem created_at e updated_at

    public function categoria(): BelongsTo{
        return $this->belongsTo(Categorias::class, 'category_id', 'id');
    }

    public function cliente(): BelongsTo{
        return $this->belongsTo(Cliente::class, 'customer_id', 'id');
    }

    public function itemsEncomenda(): HasMany{
        return $this->hasMany(ItensEncomenda::class, 'tshirt_image_id', 'id');
    }

    public function getSlugAttribute() : String 
    {
        return $this->id.'-'.Str::slug($this->name, '-');
    }
    
}
