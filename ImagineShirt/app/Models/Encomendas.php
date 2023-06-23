<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Cliente;
use App\Models\ItensEncomenda;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Encomendas extends Model
{
    use HasFactory;
    protected $table = 'orders';
    protected $fillable = [
        'status',
        'customer_id',
        'date',
        'total_price',
        'notes',
        'nif',
        'address',
        'payment_type',
        'payment_ref',
        'receipt_url'
    ];

    public function clientes(): BelongsTo{
        return $this->belongsTo(Cliente::class, 'customer_id', 'id');
    }

    public function itensEncomenda(): HasMany{
        return $this->hasMany(ItensEncomenda::class, 'order_id', 'id');
    }
}
