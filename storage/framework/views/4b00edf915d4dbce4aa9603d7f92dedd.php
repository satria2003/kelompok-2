

<?php $__env->startSection('content'); ?>
<style>
    .container-fluid {
        width: 100%;
        min-height: 100vh;
        background: #ffffff;
        padding: 2.5rem;
        border-radius: 1.5rem;
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        animation: fadeIn 0.8s ease-out;
    }
    h2 {
        text-align: center;
        color: #0ea5e9;
        font-weight: bold;
        font-size: 2rem;
        margin-bottom: 1.5rem;
    }
    .form-control {
        border-radius: 0.75rem;
        transition: all 0.3s ease-in-out;
        font-size: 1rem;
    }
    .form-control:focus {
        border-color: #0ea5e9;
        box-shadow: 0 0 12px rgba(14, 165, 233, 0.6);
        transform: scale(1.02);
    }
    .btn {
        border-radius: 2.5rem;
        padding: 0.75rem 2rem;
        transition: all 0.3s ease-in-out;
        font-size: 1rem;
        font-weight: bold;
    }
    .btn-primary {
        background: linear-gradient(135deg, #0ea5e9, #0284c7);
        border: none;
    }
    .btn-primary:hover {
        background: linear-gradient(135deg, #0284c7, #0369a1);
        transform: translateY(-3px) scale(1.05);
    }
    .btn-secondary:hover {
        transform: translateY(-3px) scale(1.05);
    }
    img {
        display: block;
        margin: 0 auto;
        border-radius: 1rem;
        transition: transform 0.3s ease-in-out;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }
    img:hover {
        transform: scale(1.1) rotate(2deg);
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<div class="container-fluid py-4">
    <h2 class="mb-4"> Edit Produk</h2>

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

    <form action="<?php echo e(route('admin.produk.update', $produk)); ?>" method="POST" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <div class="mb-3">
            <label for="nama_produk" class="form-label">Nama Produk</label>
            <input type="text" name="nama_produk" value="<?php echo e(old('nama_produk', $produk->nama_produk)); ?>" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi</label>
            <textarea name="deskripsi" class="form-control" rows="3"><?php echo e(old('deskripsi', $produk->deskripsi)); ?></textarea>
        </div>

        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="harga" class="form-label">Harga</label>
                <input type="number" name="harga" value="<?php echo e(old('harga', $produk->harga)); ?>" class="form-control" required>
            </div>
            <div class="col-md-4 mb-3">
                <label for="stok" class="form-label">Stok</label>
                <input type="number" name="stok" value="<?php echo e(old('stok', $produk->stok)); ?>" class="form-control" required>
            </div>
            <div class="col-md-4 mb-3">
                <label for="berat" class="form-label">Berat(Kg) </label>
                <input type="number" name="berat" value="<?php echo e(old('berat', $produk->berat)); ?>" class="form-control" required>
            </div>
            <div class="col-md-4 mb-3">
                <label for="diskon" class="form-label">Diskon (%)</label>
                <input type="number" name="diskon" value="<?php echo e(old('diskon', $produk->diskon)); ?>" class="form-control">
            </div>
        </div>

        <div class="mb-3">
            <label for="id_kategori" class="form-label">Kategori</label>
            <select name="id_kategori" class="form-control" required>
                <option value="">-- Pilih Kategori --</option>
                <?php $__currentLoopData = $kategori; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($k->id_kategori); ?>" <?php echo e($produk->id_kategori == $k->id_kategori ? 'selected' : ''); ?>>
                        <?php echo e($k->nama_kategori); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>

        <div class="mb-3 text-center">
            <label for="foto_produk" class="form-label">Foto Produk</label><br>
            <?php if($produk->foto_produk): ?>
                <img src="<?php echo e(asset('images/' . $produk->foto_produk)); ?>" width="180" class="mb-3">
            <?php endif; ?>
            <input type="file" name="foto_produk" class="form-control">
        </div>

        <div class="d-flex justify-content-between">
            <a href="<?php echo e(route('admin.produk.index')); ?>" class="btn btn-secondary">Kembali</a>
            <button type="submit" class="btn btn-primary">Update Produk</button>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\projek\90%\furniture\resources\views/admin/produk/edit.blade.php ENDPATH**/ ?>