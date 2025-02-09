<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    public function index()
    {
        $products = Produk::all();
        return view('dashboard', compact('products'));
    }

    public function create()
    {
        return view('produk.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'gambar'    => 'string|nullable',
            'produk'    => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'stok'      => 'required|integer|min:0',
            'harga'     => 'required|numeric|min:0',
            'diskon'    => 'nullable|numeric|min:0|max:100',
            'rating'    => 'nullable|numeric|min:0|max:5',
        ]);

        $data = $request->all();

        Produk::create($data);

        return redirect()->route('produk.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function show($id)
    {
        $produk = Produk::findOrFail($id);
        return view('produk.show', compact('produk'));
    }

    public function edit($id)
    {
        $produk = Produk::findOrFail($id);
        return view('produk.edit', compact('produk'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'gambar'    => 'string|nullable',
            'produk'    => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'stok'      => 'required|integer|min:0',
            'harga'     => 'required|numeric|min:0',
            'diskon'    => 'nullable|numeric|min:0|max:100',
            'rating'    => 'nullable|numeric|min:0|max:5',
        ]);

        $produk = Produk::findOrFail($id);
        $data   = $request->all();
        $produk->update($data);

        return redirect()->route('produk.index')->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);
        if ($produk->gambar) {
            Storage::delete('public/' . $produk->gambar);
        }
        $produk->delete();

        return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus!');
    }
}
