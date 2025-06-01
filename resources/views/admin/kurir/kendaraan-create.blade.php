@extends('admin.admin')

@section('content')
<div class="container">
    <h4 class="mb-4">Tambah Kendaraan</h4>

    <form action="{{ route('admin.kendaraan.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Plat Nomor</label>
            <input type="text" name="plat_nomor" class="form-control" value="{{ old('plat_nomor') }}" required>
        </div>

        <div class="mb-3">
            <label>Jenis</label>
            <input type="text" name="jenis" class="form-control" value="{{ old('jenis') }}" required>
        </div>

        <div class="mb-3">
            <label>Merk</label>
            <input type="text" name="merk" class="form-control" value="{{ old('merk') }}" required>
        </div>

        <div class="mb-3">
            <label>Kurir (Opsional)</label>
            <select name="kurir_id" class="form-control">
                <option value="">-- Pilih Kurir --</option>
                @foreach ($kurirs as $kurir)
                    <option value="{{ $kurir->id }}" {{ old('kurir_id') == $kurir->id ? 'selected' : '' }}>
                        {{ $kurir->nama }} ({{ $kurir->email }})
                    </option>
                @endforeach
            </select>
        </div>

        <button class="btn btn-primary">Simpan</button>
        <a href="{{ route('admin.kendaraan.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
