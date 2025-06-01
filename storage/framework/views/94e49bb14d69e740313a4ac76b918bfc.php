

<?php $__env->startSection('content'); ?>
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

    
    <?php if(session('success')): ?>
        <div class="alert alert-success"><?php echo e(session('success')); ?></div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="alert alert-danger"><?php echo e(session('error')); ?></div>
    <?php endif; ?>

    
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
                <?php $__empty_1 = true; $__currentLoopData = $kurirs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $kurir): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($index + 1); ?></td>
                        <td><?php echo e($kurir->nama ?? '-'); ?></td>
                        <td><?php echo e($kurir->email); ?></td>
                        <td><?php echo e($kurir->no_telepon ?? '-'); ?></td>
                        <td>
                            <?php if($kurir->email_verified_at): ?>
                                <span class="badge bg-success">Terverifikasi</span>
                            <?php else: ?>
                                <span class="badge bg-warning text-dark">Belum</span>
                            <?php endif; ?>
                        </td>
                        <td><?php echo e($kurir->created_at->format('d M Y')); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="6" class="text-center text-muted">Belum ada data kurir.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>


<div class="modal fade" id="modalTambahKurir" tabindex="-1" aria-labelledby="modalTambahKurirLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="<?php echo e(route('admin.kurir.store')); ?>">
            <?php echo csrf_field(); ?>
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


<div class="modal fade" id="modalVerifikasiKurir" tabindex="-1" aria-labelledby="modalVerifikasiKurirLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="<?php echo e(route('admin.kurir.verifikasi')); ?>">
            <?php echo csrf_field(); ?>
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\projek\90%\furniture\resources\views/admin/kurir/index.blade.php ENDPATH**/ ?>