<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Cores;
use App\Models\TShirts;

class ItensEncomenda extends Model
{
    use HasFactory;
    protected $table = 'order_items';
    public $timestamps = false;

    public function cores(): BelongsTo{
        return $this->belongsTo(Cores::class, 'color_code', 'code')->withTrashed();
    }

    public function tshirts(): BelongsTo{
        return $this->belongsTo(TShirts::class, 'tshirt_image_id', 'id')->withTrashed();
    }

    public function encomendas(): BelongsTo{
        return $this->belongsTo(Encomendas::class, 'order_id', 'id');
    }
    
}
