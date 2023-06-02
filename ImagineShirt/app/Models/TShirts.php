<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Categorias;

class TShirts extends Model
{
    use HasFactory;
    protected $table = 'tshirt_images';
    // pk é id (incrementavel) inteiro - tem created_at e updated_at

    public function categoria(): BelongsTo{
        return $this->belongsTo(Categorias::class, 'category_id', 'id');
    }
    
}
