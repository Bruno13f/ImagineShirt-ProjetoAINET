<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Cores;
use App\Models\TShirts;

class ItemsEncomenda extends Model
{
    use HasFactory;
    protected $table = 'order_items';

    public function cor(): BelongsTo{
        return $this->belongsTo(Cores::class, 'color_code', 'id');
    }

    public function tshirts(): BelongsTo{
        return $this->belongsTo(TShirts::class, 'tshirt_image_id', 'id');
    }

    
}
