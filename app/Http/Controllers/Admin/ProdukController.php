<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Models\Kategori;

class ProdukController extends Controller
{
    public function index(Request $request)
    {
        $query = Produk::query();

        if ($request->filter == 'discount') {
            $query->where('diskon', '>', 0);
        } elseif ($request->filter == 'no_discount') {
            $query->where(function ($q) {
                $q->whereNull('diskon')->orWhere('diskon', 0);
            });
        } elseif ($request->filter == 'newest') {
            $query->orderBy('tanggal_dibuat', 'desc');
        } elseif ($request->filter == 'oldest') {
            $query->orderBy('tanggal_dibuat', 'asc');
        }

        $produk = $query->get();
        return view('admin.produk.index', compact('produk'));
    }

    public function create()
    {
        $kategori = Kategori::all();
        return view('admin.produk.create', compact('kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required|max:100',
            'deskripsi' => 'nullable',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'berat' => 'required|integer|min:0',
            'id_kategori' => 'required|integer|exists:kategori,id_kategori',
            'foto_produk' => 'nullable|file|max:2048',
            'diskon' => 'nullable|numeric|min:0|max:100',
        ]);

        $data = $request->except('foto_produk');

        if ($request->hasFile('foto_produk')) {
            $file = $request->file('foto_produk');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images'), $filename); // Simpan langsung ke public/images
            $data['foto_produk'] = $filename; // Simpan nama file saja ke database
        }

        Produk::create($data);

        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil ditambahkan');
    }

    public function edit(Produk $produk)
    {
        $kategori = Kategori::all();
        return view('admin.produk.edit', compact('produk', 'kategori'));
    }

    public function update(Request $request, $id)
    {
        $produk = Produk::findOrFail($id);

        $data = $request->validate([
            'nama_produk' => 'required',
            'deskripsi' => 'required',
            'harga' => 'required|numeric',
            'stok' => 'required|numeric',
            'berat' => 'required|integer|min:0',
            'id_kategori' => 'required|numeric',
            'diskon' => 'nullable|numeric',
            'foto_produk' => 'nullable|file|max:2048',
        ]);

        if ($request->hasFile('foto_produk')) {
            // Hapus file lama dari public/images jika ada
            $oldPath = public_path('images/' . $produk->foto_produk);
            if ($produk->foto_produk && File::exists($oldPath)) {
                File::delete($oldPath);
            }

            // Simpan file baru
            $file = $request->file('foto_produk');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images'), $filename);
            $data['foto_produk'] = $filename;
        }

        $produk->update($data);

        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Produk $produk)
    {
        if ($produk->foto_produk) {
            $filePath = public_path('images/' . $produk->foto_produk);
            if (File::exists($filePath)) {
                File::delete($filePath);
            }
        }

        $produk->delete();

        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil dihapus');
    }
}
