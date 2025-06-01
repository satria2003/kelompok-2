@extends('admin.admin')
<style>
    .btn-custom-dark {
    background-color: #1A3636 !important;
    color: #ffffff !important;
    border: none;
}

.btn-custom-dark:hover {
    background-color: #162e2e !important;
}

</style>
@section('content')
<div class="container py-4">
    <h2 class="mb-4">Tambah Produk Baru</h2>

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

    <form action="{{ route('admin.produk.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="nama_produk" class="form-label">Nama Produk</label>
            <input type="text" name="nama_produk" value="{{ old('nama_produk') }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi</label>
            <textarea name="deskripsi" class="form-control" rows="3">{{ old('deskripsi') }}</textarea>
        </div>

        <div class="row">
            <div class="col-md-3 mb-3">
                <label for="harga" class="form-label">Harga</label>
                <input type="number" name="harga" value="{{ old('harga') }}" class="form-control" required>
            </div>
            <div class="col-md-3 mb-3">
                <label for="stok" class="form-label">Stok</label>
                <input type="number" name="stok" value="{{ old('stok') }}" class="form-control" required>
            </div>
            <div class="col-md-3 mb-3">
                <label for="berat" class="form-label">Berat (gram)</label>
                <input type="number" name="berat" value="{{ old('berat') }}" class="form-control" required>
            </div>
            <div class="col-md-3 mb-3">
                <label for="diskon" class="form-label">Diskon (%)</label>
                <input type="number" name="diskon" value="{{ old('diskon') }}" class="form-control">
            </div>
        </div>

        <div class="mb-3">
            <label for="id_kategori" class="form-label">Kategori</label>
            <select name="id_kategori" class="form-control" required>
                <option value="">-- Pilih Kategori --</option>
                @foreach ($kategori as $k)
                    <option value="{{ $k->id_kategori }}" {{ old('id_kategori') == $k->id_kategori ? 'selected' : '' }}>
                        {{ $k->nama_kategori }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="foto_produk" class="form-label">Foto Produk</label>
            <input type="file" name="foto_produk" class="form-control">
        </div>

        <button type="submit" class="btn btn-custom-dark">Simpan Produk</button>
        <a href="{{ route('admin.produk.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
