<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Transaksi extends Model
{
    protected $table = 'transaksi';
    protected $fillable = ['kode_transaksi', 'tanggal'];
    public $timestamps = true;

    public static function generateCode()
    {
        $dateCode = date('ymd');
        $lastTransaction = self::select([DB::raw('MAX(kode_transaksi) AS last_code')])
            ->where('kode_transaksi', 'LIKE', $dateCode . '%')
            ->first();

        $lastCode = !is_null($lastTransaction) ? $lastTransaction->last_code : null;
        $code = $dateCode . '0001';

        if (!is_null($lastCode)) {
            $increment = str_pad(((int)substr($lastCode, 6) + 1), 4, '0', STR_PAD_LEFT);
            $code = $dateCode . $increment;
        }

        return $code;
    }

    public function detailTransaksi()
    {
        return $this->hasMany(DetailTransaksi::class, 'id_transaksi', 'id');
    }
}
