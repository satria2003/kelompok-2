

<?php $__env->startSection('content'); ?>
<style>
body {
    background-color: #FEFAE0;
    color: #1A3636;
}

.user-container {
    padding: 2rem;
    animation: fadeIn 1s ease;
}

.user-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
}

.user-header h2 {
    color: #1A3636;
    font-weight: 700;
}

.user-card {
    background: white;
    border-radius: 1.5rem;
    padding: 1.5rem;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    transition: box-shadow 0.3s ease;
}

.user-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 1.5rem;
    animation: slideIn 0.8s ease;
}

.user-table th,
.user-table td {
    padding: 1rem;
    text-align: left;
    border-bottom: 2px solid #e2e8f0;
}

.user-table th {
    background: #1A3636;
    color: white;
    font-weight: 600;
}

.user-table td {
    color: #1e293b;
    vertical-align: middle;
}

.btn-delete {
    background-color: #ef4444;
    color: white;
    padding: 0.5rem 0.9rem;
    border: none;
    border-radius: 999px;
    font-weight: bold;
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.2s ease;
    display: flex;
    align-items: center;
    gap: 0.4rem;
}

.btn-delete i {
    font-size: 1rem;
}

.btn-delete:hover {
    background-color: #dc2626;
    transform: scale(1.05);
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

<div class="container-fluid user-container">
    <div class="user-header">
        <h2>👥 Total User: <?php echo e($totalUser); ?></h2>
    </div>
    <div class="user-card">
        <table class="user-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Password</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($index + 1); ?></td>
                    <td><?php echo e($user->username); ?></td>
                    <td><?php echo e($user->email); ?></td>
                    <td><?php echo e($user->password); ?></td>
                    <td>
                        <form id="deleteForm-<?php echo e($user->id_pengguna); ?>" action="<?php echo e(route('admin.user.destroy', $user->id_pengguna)); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="button" class="btn-delete" onclick="confirmDelete(<?php echo e($user->id_pengguna); ?>)">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(userId) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data ini akan dihapus dan tidak bisa dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#1A3636',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('deleteForm-' + userId).submit();

                Swal.fire({
                    title: 'Berhasil!',
                    text: 'User telah dihapus.',
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 1500,
                    willClose: () => {
                        window.location.reload();
                    }
                });
            }
        });
    }
</script>

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\projek\90%\furniture\resources\views/admin/user/index.blade.php ENDPATH**/ ?>