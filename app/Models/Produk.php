<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $table = 'produk';
    protected $fillable = [
        'gambar',
        'produk',
        'deskripsi',
        'stok',
        'harga',
        'diskon',
        'rating',
    ];
    public $timestamps = true;

    public function detailTransaksi()
    {
        return $this->hasMany(DetailTransaksi::class, 'produk_id', 'id');
    }
}
