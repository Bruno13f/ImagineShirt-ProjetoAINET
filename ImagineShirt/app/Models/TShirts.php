<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Categorias;
use Illuminate\Support\Str;
use App\Models\ItemsEncomenda;

class TShirts extends Model
{
    use HasFactory;
    protected $table = 'tshirt_images';
    // pk é id (incrementavel) inteiro - tem created_at e updated_at

    public function categoria(): BelongsTo{
        return $this->belongsTo(Categorias::class, 'category_id', 'id');
    }

    public function getSlugAttribute() : String 
    {
        return $this->id.'-'.Str::slug($this->name, '-');
    }

    public function itemsEncomenda(): HasMany{
        return $this->hasMany(ItemsEncomenda::class, 'tshirt_image_id', 'id');
    }
    
}
