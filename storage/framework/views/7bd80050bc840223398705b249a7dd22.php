
<style>
    .btn-custom-dark {
    background-color: #1A3636 !important;
    color: #ffffff !important;
    border: none;
}

.btn-custom-dark:hover {
    background-color: #162e2e !important;
}

</style>
<?php $__env->startSection('content'); ?>
<div class="container py-4">
    <h2 class="mb-4">Tambah Produk Baru</h2>

    <?php if($errors->any()): ?>
        <div class="alert alert-danger">
            <strong>Ups!</strong> Ada beberapa masalah:<br><br>
            <ul>
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="<?php echo e(route('admin.produk.store')); ?>" method="POST" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>

        <div class="mb-3">
            <label for="nama_produk" class="form-label">Nama Produk</label>
            <input type="text" name="nama_produk" value="<?php echo e(old('nama_produk')); ?>" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi</label>
            <textarea name="deskripsi" class="form-control" rows="3"><?php echo e(old('deskripsi')); ?></textarea>
        </div>

        <div class="row">
            <div class="col-md-3 mb-3">
                <label for="harga" class="form-label">Harga</label>
                <input type="number" name="harga" value="<?php echo e(old('harga')); ?>" class="form-control" required>
            </div>
            <div class="col-md-3 mb-3">
                <label for="stok" class="form-label">Stok</label>
                <input type="number" name="stok" value="<?php echo e(old('stok')); ?>" class="form-control" required>
            </div>
            <div class="col-md-3 mb-3">
                <label for="berat" class="form-label">Berat (gram)</label>
                <input type="number" name="berat" value="<?php echo e(old('berat')); ?>" class="form-control" required>
            </div>
            <div class="col-md-3 mb-3">
                <label for="diskon" class="form-label">Diskon (%)</label>
                <input type="number" name="diskon" value="<?php echo e(old('diskon')); ?>" class="form-control">
            </div>
        </div>

        <div class="mb-3">
            <label for="id_kategori" class="form-label">Kategori</label>
            <select name="id_kategori" class="form-control" required>
                <option value="">-- Pilih Kategori --</option>
                <?php $__currentLoopData = $kategori; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($k->id_kategori); ?>" <?php echo e(old('id_kategori') == $k->id_kategori ? 'selected' : ''); ?>>
                        <?php echo e($k->nama_kategori); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="foto_produk" class="form-label">Foto Produk</label>
            <input type="file" name="foto_produk" class="form-control">
        </div>

        <button type="submit" class="btn btn-custom-dark">Simpan Produk</button>
        <a href="<?php echo e(route('admin.produk.index')); ?>" class="btn btn-secondary">Kembali</a>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\projek\90%\furniture\resources\views/admin/produk/create.blade.php ENDPATH**/ ?>