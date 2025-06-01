@extends('admin.admin')

@section('content')
<style>
body {
    background-color: #FEFAE0 ;
    color: #1A3636;
}

.produk-grid {
    display: flex;
    flex-wrap: wrap;
    gap: 2rem;
    padding: 2rem;
    justify-content: center;
}

.produk-card {
    flex: 0 1 calc(25% - 2rem);
    background: #ffffff;
    border-radius: 1.5rem;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    animation: zoomIn 0.8s ease;
    transition: box-shadow 0.3s ease;
    display: flex;
    flex-direction: column;
    height: 100%;
    min-height: 520px; 
}


.produk-image {
    background-color: #f3f4f6;
    height: 250px;
    text-align: center;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    width: 100%;
}

.produk-image img {
    height: 100%;
    width: auto;
    object-fit: contain;
    display: block;
}



.produk-card-content {
    padding: 1.5rem;
    text-align: center;
    width: 100%;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    flex-grow: 1;
}


.produk-card:hover {
    box-shadow: 0 10px 30px rgba(255, 255, 255, 0.15);
}

.produk-card-content h5 {
    color: #1A3636;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.produk-card-content p {
    margin: 0.3rem 0;
    color: #374151;
    flex-shrink: 0;
}

.produk-actions {
    display: flex;
    justify-content: center;
    gap: 0.5rem;
    margin-top: 1rem;
    flex-wrap: wrap;
}

.btn-edit,
.btn-danger {
    border-radius: 2rem;
    padding: 0.5rem 1rem;
    border: none;
    cursor: pointer;
    font-weight: bold;
    transition: background 0.3s, transform 0.2s;
}

.btn-edit {
    background: #1A3636;
    color: #fff;
}
.btn-edit:hover {
    background: #ffffff;
    transform: scale(1.05);
}

.btn-danger {
    background: #751414;
    color: #fff;
}
.btn-danger:hover {
    background: #751414;
    transform: scale(1.05);
}

@keyframes zoomIn {
    0% { transform: scale(0.8); opacity: 0; }
    100% { transform: scale(1); opacity: 1; }
}

/* Filter & Button */
.filter-tags {
    margin-bottom: 1.5rem;
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
}

.filter-tags button {
    padding: 0.5rem 1rem;
    background-color: #e2e8f0;
    border: none;
    border-radius: 20px;
    cursor: pointer;
    color: #334155;
    transition: 0.2s;
}

.filter-tags button:hover {
    background-color: #cbd5e1;
}

.filter-tags .active {
    background-color: #1A3636;
    color: white;
    font-weight: bold;
}


.btn-create {
    margin-top: 1rem;
    display: inline-block;
    padding: 0.6rem 1.2rem;
    background-color: #1A3636;
    color: white;
    font-weight: 600;
    border-radius: 9999px;
    text-decoration: none;
    transition: background-color 0.3s ease;
}
.btn-create:hover {
    background-color: #ffffff;
}

</style>

<div class="container-fluid py-4">
    <h2 class="mb-4 text-center" style="color: 1A3636#;">📦 Daftar Produk</h2>
    
    <div class="filter-tags">
        <form method="GET" action="{{ route('admin.produk.index') }}">
            <button type="submit" name="filter" value="" class="{{ request('filter') == '' ? 'active' : '' }}">Semua</button>
            <button type="submit" name="filter" value="discount" class="{{ request('filter') == 'discount' ? 'active' : '' }}">Diskon</button>
            <button type="submit" name="filter" value="no_discount" class="{{ request('filter') == 'no_discount' ? 'active' : '' }}">Tanpa Diskon</button>
            <button type="submit" name="filter" value="newest" class="{{ request('filter') == 'newest' ? 'active' : '' }}">Terbaru</button>
            <button type="submit" name="filter" value="oldest" class="{{ request('filter') == 'oldest' ? 'active' : '' }}">Terlama</button>
        </form>
    </div>
    
    <a href="{{ route('admin.produk.create') }}" class="btn btn-create">➕ Tambah Produk</a>
</div>
    
    
    
<div class="produk-grid">
    @foreach ($produk as $item)
    <div class="produk-card">
        <a href="{{ route('admin.produk.edit', $item->id_produk) }}">
            <div class="produk-image">
    <img src="{{ asset('images/' . $item->foto_produk) }}"
         alt="Foto Produk"
         onerror="this.onerror=null; this.src='{{ asset('images/default.png') }}';">
</div>

        </a>
        <div class="produk-card-content">
            <h5>{{ $item->nama_produk }}</h5>
            {{-- Tampilkan harga dan diskon --}}
            @if ($item->diskon && $item->diskon > 0)
                @php
                    $hargaAsli = $item->harga;
                    $potongan = ($item->diskon / 100) * $item->harga;
                    $hargaDiskon = $item->harga - $potongan;
                @endphp
                <p>
                    <span style="text-decoration: line-through; color: #888;">
                        Rp {{ number_format($hargaAsli, 0, ',', '.') }}
                    </span><br>
                    <span style="color: #e11d48; font-weight: bold;">
                        Rp {{ number_format($hargaDiskon, 0, ',', '.') }}
                    </span>
                    <small style="background-color: #b9300e; color: white; padding: 2px 6px; border-radius: 4px;">
                        -{{ $item->diskon }}%
                    </small>
                </p>
            @else
                <p>Rp {{ number_format($item->harga, 0, ',', '.') }}</p>
            @endif
            <p>Stok: {{ $item->stok }}</p>

            <div class="produk-actions">    
                <a href="{{ route('admin.produk.edit', $item->id_produk) }}" class="btn btn-edit">
                    <i class="fas fa-pen-to-square"></i> Edit
                </a>
                <form action="{{ route('admin.produk.destroy', $item->id_produk) }}" method="POST" class="delete-form">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash-alt"></i> Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
    @endforeach
</div>



<script>
    let selectedFilters = [];

    function toggleFilter(filter) {
        const index = selectedFilters.indexOf(filter);
        
        if (index === -1) {
            selectedFilters.push(filter); // Tambahkan jika belum ada
        } else {
            selectedFilters.splice(index, 1); // Hapus jika sudah ada
        }

        updateFilterDisplay();
    }

    function updateFilterDisplay() {
        const filterContainer = document.getElementById("selected-filters");
        filterContainer.innerHTML = "";

        selectedFilters.forEach(filter => {
            const filterTag = document.createElement("div");
            filterTag.classList.add("filter-tag");
            filterTag.innerHTML = `${filter} <button onclick="removeFilter('${filter}')">x</button>`;
            filterContainer.appendChild(filterTag);
        });

        document.getElementById("filter-input").value = selectedFilters.join(",");
    }

    function removeFilter(filter) {
        selectedFilters = selectedFilters.filter(f => f !== filter);
        updateFilterDisplay();
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Menggunakan SweetAlert2 untuk konfirmasi penghapusan produk
    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function(event) {
            event.preventDefault();  // Mencegah pengiriman form secara langsung

            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Anda tidak bisa mengembalikannya setelah dihapus!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Jika tombol "Ya" dipilih, tampilkan animasi centang
                    Swal.fire({
                        title: 'Berhasil!',
                        text: 'Produk telah dihapus.',
                        icon: 'success',
                        showConfirmButton: false,
                        timer: 1500,  // Animasi centang tampil selama 1,5 detik
                        willClose: () => {
                            form.submit();  // Kirimkan form setelah animasi centang selesai
                        }
                    });
                }
            });
        });
    });
</script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">


@endsection
