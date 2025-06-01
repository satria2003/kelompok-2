@extends('layouts.admin')

@section('content')
<h1>Daftar Produk</h1>
<a href="{{ route('produk.create') }}" class="btn btn-primary">Tambah Produk</a>
<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Harga</th>
            <th>Stok</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($produk as $item)
        <tr>
            <td>{{ $item->id_produk }}</td>
            <td>{{ $item->nama_produk }}</td>
            <td>{{ $item->harga }}</td>
            <td>{{ $item->stok }}</td>
            <td>
                <a href="{{ route('produk.edit', $item->id_produk) }}" class="btn btn-warning">Edit</a>
                <form action="{{ route('produk.destroy', $item->id_produk) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
