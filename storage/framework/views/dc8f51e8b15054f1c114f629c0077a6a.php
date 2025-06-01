

<?php $__env->startSection('content'); ?>
<div class="container">
    <h4 class="mb-4">Data Kendaraan</h4>

    <a href="<?php echo e(route('admin.kendaraan.create')); ?>" class="btn btn-primary mb-3">+ Tambah Kendaraan</a>

    <?php if(session('success')): ?>
        <div class="alert alert-success"><?php echo e(session('success')); ?></div>
    <?php endif; ?>

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
            <?php $__currentLoopData = $kendaraans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kendaraan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($kendaraan->plat_nomor); ?></td>
                <td><?php echo e($kendaraan->jenis); ?></td>
                <td><?php echo e($kendaraan->merk); ?></td>
                <td><?php echo e($kendaraan->kurir ? $kendaraan->kurir->nama : '-'); ?></td>
                <td>
                    <a href="<?php echo e(route('admin.kendaraan.edit', $kendaraan->id)); ?>" class="btn btn-sm btn-warning">Edit</a>
                    <form action="<?php echo e(route('admin.kendaraan.destroy', $kendaraan->id)); ?>" method="POST" class="d-inline"
                        onsubmit="return confirm('Yakin ingin menghapus kendaraan ini?');">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button class="btn btn-sm btn-danger">Hapus</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <?php if($kendaraans->isEmpty()): ?>
            <tr>
                <td colspan="5" class="text-center">Tidak ada data kendaraan.</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\projek\90%\furniture\resources\views/admin/kurir/kendaraan.blade.php ENDPATH**/ ?>