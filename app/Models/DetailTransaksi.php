<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailTransaksi extends Model
{
    protected $table = 'detail_transaksi';
    protected $fillable = ['id_transaksi', 'id_produk', 'jumlah'];
    public $timestamps = true;

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'id_transaksi', 'id');
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk', 'id');
    }


    // DASHBOARD NEEDS
    public static function listTransaksi()
    {
        $result = DetailTransaksi::with('produk', 'transaksi')->get();

        // list transaki : kode transaksi, nama produk, quantity, harga, total
        $data = [];
        foreach ($result as $item) {
            $data[] = [
                'kode_transaksi' => $item->transaksi->kode_transaksi,
                'nama_produk' => $item->produk->produk,
                'quantity' => $item->jumlah,
                'harga' => $item->produk->harga,
                'total' => $item->jumlah * $item->produk->harga
            ];
        }

        return $data;
    }

    // total transaksi
    public static function totalTransaksi()
    {
        return DetailTransaksi::count();
    }

    // total pendapatan
    public static function totalPendapatan()
    {
        $total = 0;
        $transaksi = DetailTransaksi::all();
        foreach ($transaksi as $item) {
            $total += $item->jumlah * $item->produk->harga;
        }
        return $total;
    }
}
