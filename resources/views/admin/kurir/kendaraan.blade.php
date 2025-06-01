@extends('admin.admin')

@section('content')
<div class="container">
    <h4 class="mb-4">Data Kendaraan</h4>

    <a href="{{ route('admin.kendaraan.create') }}" class="btn btn-primary mb-3">+ Tambah Kendaraan</a>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Plat Nomor</th>
                <th>Jenis</th>
                <th>Merk</th>
                <th>Kurir</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($kendaraans as $kendaraan)
            <tr>
                <td>{{ $kendaraan->plat_nomor }}</td>
                <td>{{ $kendaraan->jenis }}</td>
                <td>{{ $kendaraan->merk }}</td>
                <td>{{ $kendaraan->kurir ? $kendaraan->kurir->nama : '-' }}</td>
                <td>
                    <a href="{{ route('admin.kendaraan.edit', $kendaraan->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('admin.kendaraan.destroy', $kendaraan->id) }}" method="POST" class="d-inline"
                        onsubmit="return confirm('Yakin ingin menghapus kendaraan ini?');">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach

            @if($kendaraans->isEmpty())
            <tr>
                <td colspan="5" class="text-center">Tidak ada data kendaraan.</td>
            </tr>
            @endif
        </tbody>
    </table>
</div>
@endsection
