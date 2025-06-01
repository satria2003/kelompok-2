

<?php $__env->startSection('content'); ?>
<link href="<?php echo e(asset('assets/css/style.css')); ?>" rel="stylesheet">
<!-- Custom Style untuk tampilan SB Admin 2 dengan penyesuaian -->
<style>
body {
    background: #FEFAE0;
    color: #1A3636;
    overflow-x: hidden;
}

.header-title {
    font-size: 2rem;
    font-weight: 700;
    color: #1A3636;
    margin-bottom: 1.5rem;
}

.card-stat {
    background: #ffffff;
    border-left: 0.25rem solid #1A3636;
    border-radius: 0.5rem;
    padding: 1.5rem;
    box-shadow: 0 0.15rem 1.75rem 0 rgba(0,0,0,.1);
    transition: all 0.3s ease-in-out;
}

.card-stat:hover {
    transform: translateY(-4px);
    box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.1);
}

.card-stat h5 {
    font-size: 1rem;
    font-weight: 700;
    color: #4e4e4e;
}

.card-stat h2 {
    font-size: 1.75rem;
    font-weight: 900;
    color: #1A3636;
}

.chart-container {
    background: #ffffff;
    border-radius: 0.5rem;
    padding: 2rem;
    margin-top: 2rem;
    box-shadow: 0 0.15rem 1.75rem 0 rgba(0,0,0,.1);
}

.button-glow {
    background: #1A3636;
    color: #fff;
    padding: 10px 20px;
    border-radius: 0.35rem;
    border: none;
    font-weight: bold;
    transition: all 0.3s ease-in-out;
}

.button-glow:hover {
    background: #132c2c;
    transform: scale(1.05);
}

#page-loader {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: #FEFAE0;
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
    transition: opacity 0.5s ease;
    flex-direction: column;
}

.loader-circle {
    width: 60px;
    height: 60px;
    border: 5px solid #dcdcdc;
    border-top: 5px solid #1A3636;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

.loader-text {
    margin-top: 15px;
    color: #1A3636;
    font-size: 1.2rem;
    font-weight: bold;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
    .bg-c-orange { background-color: #fd7e14; }
    .bg-c-info { background-color: #0dcaf0; }
    .bg-c-success { background-color: #198754; }

    .text-white { color: #fff !important; }

</style>

<div id="page-loader">
    <div class="loader-circle"></div>
    <h5 class="loader-text">Loading Dashboard...</h5>
</div>

<main class="container-fluid py-5 px-4" style="display: none;" id="main-content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="header-title">Dashboard Admin</h2>
        <button id="refreshButton" class="button-glow">Refresh Data</button>
    </div>
<div class="row g-4">
    <!-- Total User -->
    <div class="col-xl-4 col-md-6 d-flex">
        <div class="card prod-p-card bg-c-red w-100">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="m-b-2 text-white">Total User</h6>
                    <h3 class="m-b-0 text-white text-nowrap"><?php echo e($totalUser); ?></h3>
                </div>
                <div>
                    <i class="fas fa-users text-c-red f-18"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Produk -->
    <div class="col-xl-4 col-md-6 d-flex">
        <div class="card prod-p-card bg-c-blue w-100">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="m-b-2 text-white">Total Produk</h6>
                    <h3 class="m-b-0 text-white text-nowrap"><?php echo e($totalProduk); ?></h3>
                </div>
                <div>
                    <i class="fas fa-boxes text-c-blue f-18"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Penjualan -->
    <div class="col-xl-4 col-md-6 d-flex">
        <div class="card prod-p-card bg-c-green w-100">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="m-b-2 text-white">Total Penjualan</h6>
                    <h3 class="m-b-0 text-white text-nowrap">Rp<?php echo e(number_format($totalPembelian, 0, ',', '.')); ?></h3>
                </div>
                <div>
                    <i class="fas fa-dollar-sign text-c-green f-18"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Barang Diproses -->
    <div class="col-xl-4 col-md-6 d-flex">
        <div class="card prod-p-card bg-c-orange w-100">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="m-b-2 text-white">Barang Diproses</h6>
                    <h3 class="m-b-0 text-white text-nowrap"><?php echo e($totalDiproses); ?></h3>
                </div>
                <div>
                    <i class="fas fa-cogs text-c-orange f-18"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Barang Dikirim -->
    <div class="col-xl-4 col-md-6 d-flex">
        <div class="card prod-p-card bg-c-info w-100">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="m-b-2 text-white">Barang Dikirim</h6>
                    <h3 class="m-b-0 text-white text-nowrap"><?php echo e($totalDikirim); ?></h3>
                </div>
                <div>
                    <i class="fas fa-shipping-fast text-c-info f-18"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Pesanan Selesai -->
    <div class="col-xl-4 col-md-6 d-flex">
        <div class="card prod-p-card bg-c-success w-100">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="m-b-2 text-white">Pesanan Selesai</h6>
                    <h3 class="m-b-0 text-white text-nowrap"><?php echo e($totalSelesai); ?></h3>
                </div>
                <div>
                    <i class="fas fa-check-circle text-c-success f-18"></i>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- Gabungan Statistik Bulanan & Penjualan Terbanyak -->
<!-- 📊 Statistik Ringkasan (Pendapatan, User, Produk) dengan spacer -->
<div class="row mt-5 align-items-start">
    <!-- Grafik Sales -->
    <div class="col-lg-8">
        <div class="chart-container">
            <h5 class="mb-4">📊 Grafik Data</h5>
            <canvas id="salesChart" style="height: 300px;"></canvas>
        </div>
    </div>



                <!-- Penjualan Terbanyak -->
                <div class="col-lg-4 col-md-12 mb-4 text-center">
                    <h6 class="mb-3 text-primary fw-bold">Penjualan Terbanyak</h6>
                    <canvas id="revenueChart" style="height: 230px;"></canvas>
                    <div id="revenue-legend" class="mt-3 d-flex justify-content-center flex-wrap gap-3"></div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Tombol Download PDF -->
<div class="row mt-5">
    <div class="col-12 text-center">
        <a href="<?php echo e(route('admin.laporan.bulanan.pdf')); ?>" class="btn btn-danger">
            📄 Download PDF
        </a>       
    </div>
</div>


<!-- Script -->
<!-- Chart.js CDN -->


<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    // Hide loader, show content
    const loader = document.getElementById('page-loader');
    loader.style.opacity = '0';
    setTimeout(() => {
        loader.style.display = 'none';
        document.getElementById('main-content').style.display = 'block';

        // Grafik Line: Pendapatan, User, Produk per Bulan
       // Grafik Gabungan dengan 2 Sumbu Y
// Grafik Pendapatan (setengah kiri)
const salesCtx = document.getElementById('salesChart').getContext('2d');

new Chart(salesCtx, {
    type: 'line',
    data: {
        labels: [
            'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des',
            '', '', '', // SPASI
            '0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '-1'
        ],
        datasets: [
            {
                label: 'Pendapatan',
                data: [
                    ...<?php echo json_encode($monthlyRevenue); ?>,
                    null, null, null, // Spacer
                    null, null, null, null, null, null, null, null, null, null, null, null
                ],
                borderColor: '#36b9cc',
                backgroundColor: 'rgba(54, 185, 204, 0.1)',
                tension: 0.4,
                fill: true,
                pointRadius: 5,
                pointHoverRadius: 8
            },
            {
                label: 'User',
                data: [
                    null, null, null, null, null, null, null, null, null, null, null, null,
                    null, null, null,
                    ...<?php echo json_encode($monthlyUsers); ?>

                ],
                borderColor: '#4e73df',
                backgroundColor: 'rgba(78, 115, 223, 0.1)',
                tension: 0.4,
                fill: true,
                pointRadius: 5,
                pointHoverRadius: 8
            },
            {
                label: 'Produk',
                data: [
                    null, null, null, null, null, null, null, null, null, null, null, null,
                    null, null, null,
                    ...<?php echo json_encode($monthlyProduk); ?>

                ],
                borderColor: '#f6c23e',
                backgroundColor: 'rgba(246, 194, 62, 0.1)',
                tension: 0.4,
                fill: true,
                pointRadius: 5,
                pointHoverRadius: 8
            }
        ]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { labels: { color: '#5a5c69' } }
        },
        scales: {
            x: {
                ticks: { color: '#5a5c69' }
            },
            y: {
                ticks: { color: '#5a5c69' },
                beginAtZero: true
            }
        }
    }
});


        // Grafik Doughnut Produk Terlaris
        const revenueCtx = document.getElementById('revenueChart').getContext('2d');
        const revenueChart = new Chart(revenueCtx, {
            type: 'doughnut',
            data: {
                labels: <?php echo json_encode($topRevenueProduk->pluck('nama_produk')); ?>,
                datasets: [{
                    data: <?php echo json_encode($topRevenueProduk->pluck('total')); ?>,
                    backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc'],
                    hoverOffset: 10,
                    borderWidth: 2
                }]
            },
            options: {
                cutout: '70%',
                plugins: {
                    legend: { display: false }
                }
            }
        });

        // Legend manual untuk Doughnut
        const legendContainer = document.getElementById('revenue-legend');
        <?php echo json_encode($topRevenueProduk->pluck('nama_produk')); ?>.forEach((label, index) => {
            const color = revenueChart.data.datasets[0].backgroundColor[index];
            const item = document.createElement('span');
            item.innerHTML = `<span style="display:inline-block;width:12px;height:12px;border-radius:50%;background:${color};margin-right:6px;"></span> ${label}`;
            item.classList.add('text-muted');
            legendContainer.appendChild(item);
        });
    }, 700);
});
</script>

<script>
    document.getElementById("refreshButton").addEventListener("click", function () {
        location.reload();
    });
</script>



<!-- Chart.js -->
<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

<!-- jQuery CDN -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<!-- Bootstrap CDN -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- jQuery Easing CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>

<!-- SB Admin 2 (Custom Script - Optional, pakai hanya kalau butuh fitur sb-admin) -->
<!-- Kalau kamu butuh sb-admin, sebaiknya taruh lokal. Tapi bisa juga dari CDN kalau kamu upload ke host. -->

<!-- FontAwesome CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">



<?php $__env->stopSection(); ?>


<?php echo $__env->make('admin.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\projek\90%\furniture\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>