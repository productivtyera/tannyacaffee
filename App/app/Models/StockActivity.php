<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StockActivity extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = [
        'stock_id',
        'user_id',
        'type',
        'description',
        'changes',
    ];

    protected $casts = [
        'changes' => 'array',
    ];

    public function stock(): BelongsTo
    {
        return $this->belongsTo(Stock::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
