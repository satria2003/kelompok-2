<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DetailPesanan;
use App\Models\User;
use App\Models\Produk;
use App\Models\Pesanan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUser = User::count();
        $totalProduk = Produk::count();
        $totalPembelian = Pesanan::sum('total_harga');
        $totalBarangTerjual = DetailPesanan::sum('jumlah');

        // Tambahan: Statistik berdasarkan status pesanan
        $totalDiproses = Pesanan::where('status', 'disiapkan')->count();
        $totalDikirim = Pesanan::where('status', 'diantar')->count();
        $totalSelesai = Pesanan::where('status', 'selesai')->count();

        $labels = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];

        // Pendapatan bulanan
        $monthlyRevenue = array_fill(0, 12, 0);
        $result = Pesanan::selectRaw('MONTH(tanggal_dibuat) as bulan, SUM(total_harga) as total')
            ->groupBy('bulan')->pluck('total', 'bulan');
        foreach ($result as $bulan => $total) {
            $bulanIndex = (int) $bulan;
            if ($bulanIndex >= 1 && $bulanIndex <= 12) {
                $monthlyRevenue[$bulanIndex - 1] = $total;
            }
        }

        // User bulanan
        $monthlyUsers = array_fill(0, 12, 0);
        $result = User::selectRaw('MONTH(created_at) as bulan, COUNT(*) as total')
            ->groupBy('bulan')->pluck('total', 'bulan');
        foreach ($result as $bulan => $total) {
            $bulanIndex = (int) $bulan;
            if ($bulanIndex >= 1 && $bulanIndex <= 12) {
                $monthlyUsers[$bulanIndex - 1] = $total;
            }
        }

        // Produk bulanan
        $monthlyProduk = array_fill(0, 12, 0);
        $result = Produk::selectRaw('MONTH(tanggal_dibuat) as bulan, COUNT(*) as total')
            ->groupBy('bulan')->pluck('total', 'bulan');
        foreach ($result as $bulan => $total) {
            $bulanIndex = (int) $bulan;
            if ($bulanIndex >= 1 && $bulanIndex <= 12) {
                $monthlyProduk[$bulanIndex - 1] = $total;
            }
        }

        // Top 3 produk berdasarkan pendapatan
        $topRevenueProduk = DetailPesanan::join('produk', 'detail_pesanan.id_produk', '=', 'produk.id_produk')
            ->join('pesanan', 'detail_pesanan.id_pesanan', '=', 'pesanan.id_pesanan')
            ->select('produk.nama_produk', DB::raw('SUM(detail_pesanan.jumlah * produk.harga) as total'))
            ->groupBy('produk.nama_produk')
            ->orderByDesc('total')
            ->limit(3)
            ->get();

return view('admin.dashboard', compact(
    'totalUser', 'totalProduk', 'totalPembelian', 'totalBarangTerjual',
    'totalDiproses', 'totalDikirim', 'totalSelesai',
    'labels', 'monthlyRevenue', 'monthlyUsers', 'monthlyProduk',
    'topRevenueProduk'
));

    }

    public function laporanBulananPDF()
    {
        $pendapatanBulanan = Pesanan::selectRaw(
            'YEAR(tanggal_dibuat) as tahun,
             MONTH(tanggal_dibuat) as bulan,
             SUM(total_harga) as total'
        )
        ->groupBy('tahun', 'bulan')
        ->orderBy('tahun')
        ->orderBy('bulan')
        ->get();

        $pdf = Pdf::loadView('admin.laporan-bulanan-pdf', compact('pendapatanBulanan'));

        return $pdf->download('laporan_pendapatan_bulanan.pdf');
    }
}
