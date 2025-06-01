

<?php $__env->startSection('content'); ?>
<div class="container">
    <h4 class="mb-4">Tambah Kendaraan</h4>

    <form action="<?php echo e(route('admin.kendaraan.store')); ?>" method="POST">
        <?php echo csrf_field(); ?>

        <div class="mb-3">
            <label>Plat Nomor</label>
            <input type="text" name="plat_nomor" class="form-control" value="<?php echo e(old('plat_nomor')); ?>" required>
        </div>

        <div class="mb-3">
            <label>Jenis</label>
            <input type="text" name="jenis" class="form-control" value="<?php echo e(old('jenis')); ?>" required>
        </div>

        <div class="mb-3">
            <label>Merk</label>
            <input type="text" name="merk" class="form-control" value="<?php echo e(old('merk')); ?>" required>
        </div>

        <div class="mb-3">
            <label>Kurir (Opsional)</label>
            <select name="kurir_id" class="form-control">
                <option value="">-- Pilih Kurir --</option>
                <?php $__currentLoopData = $kurirs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kurir): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($kurir->id); ?>" <?php echo e(old('kurir_id') == $kurir->id ? 'selected' : ''); ?>>
                        <?php echo e($kurir->nama); ?> (<?php echo e($kurir->email); ?>)
                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>

        <button class="btn btn-primary">Simpan</button>
        <a href="<?php echo e(route('admin.kendaraan.index')); ?>" class="btn btn-secondary">Batal</a>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\projek\90%\furniture\resources\views/admin/kurir/kendaraan-create.blade.php ENDPATH**/ ?>