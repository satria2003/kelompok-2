

<?php $__env->startSection('content'); ?>
<style>
    .detail-container {
        background-color: #FEFAE0;
        padding: 2rem;
        border-radius: 1rem;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
        animation: fadeIn 0.6s ease;
    }

    .detail-card {
        background: #ffffff;
        border-radius: 1.25rem;
        padding: 1.8rem;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
        margin-top: 1.5rem;
    }

    .detail-card h5 {
        color: #1A3636;
        font-weight: bold;
        margin-bottom: 1rem;
    }

    .detail-card p {
        color: #334155;
        margin-bottom: 0.5rem;
    }

    .table th {
        background-color: #1A3636;
        color: white;
        font-weight: 600;
    }

    .table td {
        vertical-align: middle;
        color: #1e293b;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<div class="container-fluid detail-container">
    <h2 class="mb-4">📦 Detail Pesanan</h2>

    <div class="detail-card">
        <h5>Informasi Pengguna</h5>
        <p><strong>Username:</strong> <?php echo e($pesanan->pengguna->username); ?></p>
        <p><strong>Email:</strong> <?php echo e($pesanan->pengguna->email); ?></p>

        <h5 class="mt-4">Alamat Pengiriman</h5>
        <p><strong>Nama Penerima:</strong> <?php echo e($alamat->nama_penerima ?? '-'); ?></p>
<p><strong>No. Telepon:</strong> <?php echo e($alamat->no_telepon ?? '-'); ?></p>
<p><strong>Alamat Lengkap:</strong> <?php echo e($pesanan->alamat_pengiriman ?? '-'); ?></p>
<p><strong>Provinsi ID:</strong> <?php echo e($alamat->provinsi_id ?? '-'); ?></p>
<p><strong>Nama Provinsi:</strong> <?php echo e($alamat->nama_provinsi ?? '-'); ?></p>

        <h5 class="mt-4">Order ID</h5>
        <p><?php echo e($pesanan->order_id); ?></p>

        <h5 class="mt-4">Produk dalam Pesanan</h5>
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>ID Produk</th>
                    <th>Foto</th>
                    <th>Nama Produk</th>
                    <th>Jumlah</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $pesanan->detail; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($item->id_produk); ?></td>
                        <td>
                            <?php if($item->produk && $item->produk->foto_produk): ?>
                                <img src="<?php echo e(asset('images/' . $item->produk->foto_produk)); ?>" alt="Foto Produk" width="60" height="60" style="object-fit: cover; border-radius: 8px;">
                            <?php else: ?>
                                <img src="<?php echo e(asset('images/default.png')); ?>" alt="Default" width="60" height="60">
                            <?php endif; ?>
                        </td>
                        <td><?php echo e($item->produk->nama_produk ?? '-'); ?></td>
                        <td><?php echo e($item->jumlah ?? '-'); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\projek\90%\furniture\resources\views/admin/pesanan/show.blade.php ENDPATH**/ ?>