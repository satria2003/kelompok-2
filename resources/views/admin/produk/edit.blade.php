@extends('admin.admin')

@section('content')
<style>
    .container-fluid {
        width: 100%;
        min-height: 100vh;
        background: #ffffff;
        padding: 2.5rem;
        border-radius: 1.5rem;
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        animation: fadeIn 0.8s ease-out;
    }
    h2 {
        text-align: center;
        color: #0ea5e9;
        font-weight: bold;
        font-size: 2rem;
        margin-bottom: 1.5rem;
    }
    .form-control {
        border-radius: 0.75rem;
        transition: all 0.3s ease-in-out;
        font-size: 1rem;
    }
    .form-control:focus {
        border-color: #0ea5e9;
        box-shadow: 0 0 12px rgba(14, 165, 233, 0.6);
        transform: scale(1.02);
    }
    .btn {
        border-radius: 2.5rem;
        padding: 0.75rem 2rem;
        transition: all 0.3s ease-in-out;
        font-size: 1rem;
        font-weight: bold;
    }
    .btn-primary {
        background: linear-gradient(135deg, #0ea5e9, #0284c7);
        border: none;
    }
    .btn-primary:hover {
        background: linear-gradient(135deg, #0284c7, #0369a1);
        transform: translateY(-3px) scale(1.05);
    }
    .btn-secondary:hover {
        transform: translateY(-3px) scale(1.05);
    }
    img {
        display: block;
        margin: 0 auto;
        border-radius: 1rem;
        transition: transform 0.3s ease-in-out;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }
    img:hover {
        transform: scale(1.1) rotate(2deg);
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<div class="container-fluid py-4">
    <h2 class="mb-4"> Edit Produk</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Ups!</strong> Ada beberapa masalah:<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.produk.update', $produk) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nama_produk" class="form-label">Nama Produk</label>
            <input type="text" name="nama_produk" value="{{ old('nama_produk', $produk->nama_produk) }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi</label>
            <textarea name="deskripsi" class="form-control" rows="3">{{ old('deskripsi', $produk->deskripsi) }}</textarea>
        </div>

        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="harga" class="form-label">Harga</label>
                <input type="number" name="harga" value="{{ old('harga', $produk->harga) }}" class="form-control" required>
            </div>
            <div class="col-md-4 mb-3">
                <label for="stok" class="form-label">Stok</label>
                <input type="number" name="stok" value="{{ old('stok', $produk->stok) }}" class="form-control" required>
            </div>
            <div class="col-md-4 mb-3">
                <label for="berat" class="form-label">Berat(Kg) </label>
                <input type="number" name="berat" value="{{ old('berat', $produk->berat) }}" class="form-control" required>
            </div>
            <div class="col-md-4 mb-3">
                <label for="diskon" class="form-label">Diskon (%)</label>
                <input type="number" name="diskon" value="{{ old('diskon', $produk->diskon) }}" class="form-control">
            </div>
        </div>

        <div class="mb-3">
            <label for="id_kategori" class="form-label">Kategori</label>
            <select name="id_kategori" class="form-control" required>
                <option value="">-- Pilih Kategori --</option>
                @foreach ($kategori as $k)
                    <option value="{{ $k->id_kategori }}" {{ $produk->id_kategori == $k->id_kategori ? 'selected' : '' }}>
                        {{ $k->nama_kategori }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3 text-center">
            <label for="foto_produk" class="form-label">Foto Produk</label><br>
            @if ($produk->foto_produk)
                <img src="{{ asset('images/' . $produk->foto_produk) }}" width="180" class="mb-3">
            @endif
            <input type="file" name="foto_produk" class="form-control">
        </div>

        <div class="d-flex justify-content-between">
            <a href="{{ route('admin.produk.index') }}" class="btn btn-secondary">Kembali</a>
            <button type="submit" class="btn btn-primary">Update Produk</button>
        </div>
    </form>
</div>
@endsection
