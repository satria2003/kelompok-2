@extends('admin.admin')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Daftar Kurir</h3>
        <div class="d-flex gap-2">
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalTambahKurir">
                <i class="fas fa-plus-circle me-1"></i> Tambah Kurir
            </button>
            <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalVerifikasiKurir">
                <i class="fas fa-key me-1"></i> Verifikasi Token
            </button>
        </div>
    </div>

    {{-- Notifikasi --}}
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- Tabel kurir --}}
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>No Telepon</th>
                    <th>Status Verifikasi</th>
                    <th>Tanggal Daftar</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($kurirs as $index => $kurir)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $kurir->nama ?? '-' }}</td>
                        <td>{{ $kurir->email }}</td>
                        <td>{{ $kurir->no_telepon ?? '-' }}</td>
                        <td>
                            @if ($kurir->email_verified_at)
                                <span class="badge bg-success">Terverifikasi</span>
                            @else
                                <span class="badge bg-warning text-dark">Belum</span>
                            @endif
                        </td>
                        <td>{{ $kurir->created_at->format('d M Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">Belum ada data kurir.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Modal Tambah Kurir --}}
<div class="modal fade" id="modalTambahKurir" tabindex="-1" aria-labelledby="modalTambahKurirLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('admin.kurir.store') }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahKurirLabel">Tambah Kurir</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" name="nama" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="no_telepon" class="form-label">No Telepon (opsional)</label>
                        <input type="text" name="no_telepon" class="form-control">
                    </div>
                    <p class="text-muted small mt-2">
                        Setelah disimpan, token verifikasi akan dikirim otomatis ke email kurir.
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- Modal Verifikasi Token --}}
<div class="modal fade" id="modalVerifikasiKurir" tabindex="-1" aria-labelledby="modalVerifikasiKurirLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('admin.kurir.verifikasi') }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalVerifikasiKurirLabel">Verifikasi Email Kurir</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="email_verifikasi" class="form-label">Email Kurir</label>
                        <input type="email" name="email" id="email_verifikasi" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="token" class="form-label">Kode Verifikasi</label>
                        <input type="text" name="token" class="form-control" required placeholder="6 digit token">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Verifikasi</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
