@extends('admin.admin')

@section('content')
<div class="container" style="max-width: 500px;">
    <h3 class="mb-4">Tambah Kurir</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.kurir.store') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label">Nama Lengkap</label>
            <input type="text" name="nama" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Alamat Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Nomor Telepon (opsional)</label>
            <input type="text" name="no_telepon" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary w-100">Simpan Kurir</button>

        <p class="text-muted mt-2 text-center" style="font-size: 0.875rem;">
            Setelah disimpan, sistem akan otomatis mengirim kode verifikasi ke email kurir.
        </p>
    </form>
</div>
@endsection
