<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\hasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cliente extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'customers';

    protected $fillable = [
        'id',
        'nif',
        'address',
        'default_payment_type',
        'default_payment_ref',
    ];

    public function user(): BelongsTo{
        return $this->belongsTo(User::class, 'id', 'id')->withTrashed();
    }

    public function tshirts(): HasMany{
        return $this->hasMany(TShirts::class, 'customer_id', 'id');
    }

    public function encomendas(): HasMany{
        return $this->hasMany(Encomendas::class, 'customer_id', 'id')->orderByDesc('date');
    }
}
