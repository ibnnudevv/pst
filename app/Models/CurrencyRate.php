<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CurrencyRate extends Model
{
    protected $fillable = [
        'currency_code',
        'denomination',
        'buy_rate',
        'sell_rate',
        'last_update'
    ];

    protected $casts = [
        'last_update' => 'datetime'
    ];
}
