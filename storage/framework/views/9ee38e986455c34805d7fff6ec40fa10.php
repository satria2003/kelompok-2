

<?php $__env->startSection('content'); ?>
<style>
body {
    background-color: #FEFAE0;
    color: #1A3636;
}

.pesanan-container {
    padding: 2rem;
    animation: fadeIn 1s ease;
}

.pesanan-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
}

.pesanan-header h2 {
    color: #1A3636;
    font-weight: bold;
}

.pesanan-card {
    background: white;
    border-radius: 1.5rem;
    padding: 1.5rem;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    transition: box-shadow 0.3s ease;
}

.pesanan-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 1.5rem;
    animation: slideIn 0.8s ease;
}

.pesanan-table th, .pesanan-table td {
    padding: 1rem;
    text-align: left;
    border-bottom: 2px solid #e2e8f0;
}

.pesanan-table th {
    background: #1A3636;
    color: white;
}

.pesanan-table td {
    color: #1e293b;
    vertical-align: middle;
}

.btn-delete {
    background-color: #751414;
    color: white;
    padding: 0.5rem 0.9rem;
    border: none;
    border-radius: 999px;
    font-weight: bold;
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.2s ease;
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
}

.btn-delete i {
    font-size: 1rem;
}

.btn-delete:hover {
    background-color: #751414;
    transform: scale(1.05);
}

.btn-detail {
    background-color: #1A3636;
    color: white;
    padding: 0.5rem 0.9rem;
    border: none;
    border-radius: 999px;
    font-weight: bold;
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.2s ease;
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    margin-left: 0.5rem;
}

.btn-detail:hover {
    background-color: #162e2e;
    transform: scale(1.05);
}

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
    transition: background-color 0.3s ease;
}

.filter-tags button:hover {
    background-color: #cbd5e1;
}

.filter-tags .active {
    background-color: #1A3636;
    color: white;
    font-weight: bold;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}
@keyframes slideIn {
    from { opacity: 0; transform: translateX(-20px); }
    to { opacity: 1; transform: translateX(0); }
}
</style>

<div class="container-fluid pesanan-container">
    <div class="pesanan-header">
        <h2>📦 Daftar Pesanan</h2>
    </div>

    <div class="filter-tags">
        <form method="GET" action="<?php echo e(route('admin.pesanan.index')); ?>">
            <button type="submit" name="status" value="" class="<?php echo e(request('status') == '' ? 'active' : ''); ?>">Semua</button>
            <button type="submit" name="status" value="menunggu" class="<?php echo e(request('status') == 'menunggu' ? 'active' : ''); ?>">Menunggu</button>
            <button type="submit" name="status" value="disiapkan" class="<?php echo e(request('status') == 'disiapkan' ? 'active' : ''); ?>">Disiapkan</button>
            <button type="submit" name="status" value="diantar" class="<?php echo e(request('status') == 'diantar' ? 'active' : ''); ?>">Diantar</button>
            <button type="submit" name="status" value="selesai" class="<?php echo e(request('status') == 'selesai' ? 'active' : ''); ?>">Selesai</button>
            <button type="submit" name="status" value="dibatalkan" class="<?php echo e(request('status') == 'dibatalkan' ? 'active' : ''); ?>">Dibatalkan</button>
        </form>
    </div>

    <div class="pesanan-card">
        <table class="pesanan-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Pengguna</th>
                    <th>Total Harga</th>
                    <th>Metode Pembayaran</th>
                    <th>Status</th>
                    <th>Tanggal Dibuat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $pesanans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $pesanan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($index + 1); ?></td>
                    <td><?php echo e(optional($pesanan->pengguna)->username ?? '-'); ?></td>
                    <td>Rp. <?php echo e(number_format($pesanan->total_harga, 0, ',', '.')); ?></td>
                    <td><?php echo e($pesanan->metode_pembayaran); ?></td>
                    
                    <td>
                        <form action="<?php echo e(route('admin.pesanan.updateStatus', $pesanan->id_pesanan)); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PATCH'); ?>
                            <select name="status" onchange="confirmStatusChange(this)" style="padding: 4px;">
                                <option value="menunggu" <?php echo e($pesanan->status == 'menunggu' ? 'selected' : ''); ?>>Menunggu</option>
                                <option value="disiapkan" <?php echo e($pesanan->status == 'disiapkan' ? 'selected' : ''); ?>>Disiapkan</option>
                                <option value="diantar" <?php echo e($pesanan->status == 'diantar' ? 'selected' : ''); ?>>Diantar</option>
                                <option value="selesai" <?php echo e($pesanan->status == 'selesai' ? 'selected' : ''); ?>>Selesai</option>
                                <option value="dibatalkan" <?php echo e($pesanan->status == 'dibatalkan' ? 'selected' : ''); ?>>Dibatalkan</option>
                            </select>
                        </form>
                    </td>

                    <td><?php echo e(\Carbon\Carbon::parse($pesanan->tanggal_dibuat)->format('d M Y')); ?></td>
                    <td>
                        <div style="display: flex;">
                            <form action="<?php echo e(route('admin.pesanan.destroy', $pesanan->id_pesanan)); ?>" method="POST" class="delete-form">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn-delete">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                    
                            <a href="<?php echo e(route('admin.pesanan.show', $pesanan->id_pesanan)); ?>" class="btn-detail">
                                <i class="fas fa-eye"></i> Lihat Detail
                            </a>
                        </div>
                    </td>                    
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>  
</div>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmStatusChange(selectElement) {
        const selectedStatus = selectElement.value;
        const form = selectElement.closest('form');

        const statusLabels = {
            'menunggu': 'Menunggu',
            'disiapkan': 'Disiapkan',
            'diantar': 'Diantar',
            'selesai': 'Selesai',
            'dibatalkan': 'Dibatalkan'
        };

        Swal.fire({
            title: 'Ubah Status Pesanan?',
            text: `Yakin ingin mengubah status menjadi "${statusLabels[selectedStatus]}"?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#1A3636',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, ubah',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Status diperbarui!',
                    text: 'Status pesanan berhasil diubah.',
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 1500,
                    willClose: () => {
                        form.submit();
                    }
                });
            } else {
                // Reset kembali ke value sebelumnya
                const options = selectElement.options;
                for (let i = 0; i < options.length; i++) {
                    if (options[i].defaultSelected) {
                        selectElement.value = options[i].value;
                        break;
                    }
                }
            }
        });
    }

    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function(event) {
            event.preventDefault();

            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Pesanan ini akan dihapus dan tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#1A3636',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Berhasil!',
                        text: 'Pesanan telah dihapus.',
                        icon: 'success',
                        showConfirmButton: false,
                        timer: 1500,
                        willClose: () => {
                            form.submit();
                        }
                    });
                }
            });
        });
    });
</script>

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\projek\90%\furniture\resources\views/admin/pesanan/index.blade.php ENDPATH**/ ?>