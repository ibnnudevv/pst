<?php

namespace App\Http\Controllers;

use App\Models\DetailTransaksi;
use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

use function PHPSTORM_META\map;

class ProdukController extends Controller
{
    public function index()
    {
        $products = Produk::all();
        $totalTransaction = DetailTransaksi::totalTransaksi();
        $totalIncome = DetailTransaksi::totalPendapatan();
        return view('dashboard', compact('products', 'totalTransaction', 'totalIncome'));
    }

    public function create()
    {
        return view('point-of-sales.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'gambar'    => 'string|nullable',
            'produk'    => 'required|string|max:255|unique:produk,produk',
            'deskripsi' => 'nullable|string',
            'stok'      => 'required|integer|min:0',
            'harga'     => 'required|numeric|min:0',
            'diskon'    => 'nullable|numeric|min:0|max:100',
            'rating'    => 'nullable|numeric|min:0|max:5',
        ], [
            'produk.unique' => 'Produk sudah ada!',
            'stok.min'      => 'Stok tidak boleh kurang dari 0!',
            'harga.min'     => 'Harga tidak boleh kurang dari 0!',
            'diskon.min'    => 'Diskon tidak boleh kurang dari 0!',
            'diskon.max'    => 'Diskon tidak boleh lebih dari 100!',
            'rating.min'    => 'Rating tidak boleh kurang dari 0!',
            'rating.max'    => 'Rating tidak boleh lebih dari 5!',
        ]);

        try {
            $data = $request->all();

            Produk::create($data);

            toastify()->success('Produk berhasil ditambahkan!');
            return redirect()->route('dashboard');
        } catch (\Throwable $th) {
            // show error message
            toastify()->error('Produk gagal ditambahkan!');
            return redirect()->route('dashboard')->withInput();
        }
    }

    public function show($id)
    {
        $produk = Produk::findOrFail($id);
        return view('produk.show', compact('produk'));
    }

    public function edit($id)
    {
        $produk = Produk::findOrFail($id);
        return view('point-of-sales.edit', compact('produk'));
    }

    public function update(Request $request, $id)
    {
        $produk = Produk::findOrFail($id);
        $request->validate([
            'gambar'    => 'string|nullable',
            'produk'    => 'required|string|max:255|unique:produk,produk,' . $produk->id,
            'deskripsi' => 'nullable|string',
            'stok'      => 'required|integer|min:0',
            'harga'     => 'required|numeric|min:0',
            'diskon'    => 'nullable|numeric|min:0|max:100',
            'rating'    => 'nullable|numeric|min:0|max:5',
        ], [
            'produk.unique' => 'Produk sudah ada!',
            'stok.min'      => 'Stok tidak boleh kurang dari 0!',
            'harga.min'     => 'Harga tidak boleh kurang dari 0!',
            'diskon.min'    => 'Diskon tidak boleh kurang dari 0!',
            'diskon.max'    => 'Diskon tidak boleh lebih dari 100!',
            'rating.min'    => 'Rating tidak boleh kurang dari 0!',
            'rating.max'    => 'Rating tidak boleh lebih dari 5!',
        ]);

        try {
            $data = $request->all();

            $produk->update($data);

            toastify()->success('Produk berhasil diubah!');
            return redirect()->route('dashboard');
        } catch (\Throwable $th) {
            // show error message
            toastify()->error('Produk gagal diubah!');
            return redirect()->route('pos.edit', $produk->id)->withInput();
        }
    }

    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);
        try {
            $produk->delete();

            toastify()->success('Produk berhasil dihapus!');
            return redirect()->route('dashboard');
        } catch (\Throwable $th) {
            // show error message
            toastify()->error('Produk gagal dihapus!');
            return redirect()->route('dashboard');
        }
    }

    public function preview()
    {
        $products = Produk::all();
        return view('point-of-sales.preview', compact('products'));
    }

    public function checkout(Request $request)
    {
        try {
            // Start database transaction
            DB::beginTransaction();

            // Create new transaction
            $transaksi = Transaksi::create([
                'kode_transaksi' => Transaksi::generateCode(),
                'tanggal' => now(),
            ]);

            // Get cart items from request
            $cartItems = $request->items;

            // Create detail transactions
            foreach ($cartItems as $item) {
                DetailTransaksi::create([
                    'id_transaksi' => $transaksi->id,
                    'id_produk' => $item['id'],
                    'jumlah' => $item['jumlah'],
                ]);
            }

            DB::commit();

            DB::afterCommit(function () use ($cartItems) {
                // Update product stock
                foreach ($cartItems as $item) {
                    $produk = Produk::findOrFail($item['id']);
                    $produk->update([
                        'stok' => $produk->stok - $item['jumlah']
                    ]);
                }
            });

            return response()->json([
                'success' => true,
                'message' => 'Transaksi berhasil',
                'data' => $transaksi
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Transaksi gagal: ' . $e->getMessage()
            ], 500);
        }
    }

    public function report()
    {
        $totalIncome = DetailTransaksi::totalPendapatan();
        $totalTransaction = DetailTransaksi::totalTransaksi();
        $transactions = Transaksi::with('detailTransaksi')->get();
        // transaction : total
        $transactions = $transactions->map(function ($transaction) {
            $total = $transaction->detailTransaksi->sum(function ($detail) {
                return $detail->produk->harga * $detail->jumlah;
            });

            return (object) [
                'kode_transaksi' => $transaction->kode_transaksi,
                'total' => $total,
                'tanggal' => Carbon::parse($transaction->tanggal)->format('d-m-Y H:i'),
            ];
        });

        return view('point-of-sales.report', compact('totalIncome', 'totalTransaction', 'transactions'));
    }

    public function detailReport($kode_transaksi)
    {
        // produk, quantity, harga, total
        $transaction = Transaksi::with('detailTransaksi.produk')->where('kode_transaksi', $kode_transaksi)->first();
        $transaction->produk = $transaction->detailTransaksi->map(function ($detail) {
            return (object) [
                'produk' => $detail->produk->produk,
                'quantity' => $detail->jumlah,
                'harga' => number_format($detail->produk->harga, 0, ',', '.'),
                'total' => $detail->produk->harga * $detail->jumlah,
            ];
        });

        // make it object
        $transaction = (object) [
            'kode_transaksi' => $transaction->kode_transaksi,
            'tanggal' => Carbon::parse($transaction->tanggal)->format('d-m-Y H:i'),
            'total' => $transaction->produk->sum(function ($item) {
                return $item->total;
            }),
            'produk' => $transaction->produk,
        ];

        return view('point-of-sales.detail-report', compact('transaction'));
    }
}
