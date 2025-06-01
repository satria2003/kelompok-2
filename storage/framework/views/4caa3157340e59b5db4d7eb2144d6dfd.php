<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pendapatan Bulanan</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: center; }
        th { background-color: #eee; }
        h2 { text-align: center; margin-bottom: 10px; }
    </style>
</head>
<body>
    <h2>HNFRTOOLS<br>Laporan Pendapatan Bulanan</h2>

    <table>
        <thead>
            <tr>
                <th>Tahun</th>
                <th>Bulan</th>
                <th>Total (Rp)</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $pendapatanBulanan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($row->tahun); ?></td>
                <td><?php echo e(\Carbon\Carbon::create()->month($row->bulan)->locale('id')->isoFormat('MMMM')); ?></td>
                <td><?php echo e(number_format($row->total, 2, ',', '.')); ?></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</body>
</html>
<?php /**PATH D:\projek\90%\furniture\resources\views/admin/laporan-bulanan-pdf.blade.php ENDPATH**/ ?>