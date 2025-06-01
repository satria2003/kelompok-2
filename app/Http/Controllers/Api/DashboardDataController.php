<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Produk;
use App\Models\Pesanan;
use Illuminate\Support\Facades\DB;


class DashboardDataController extends Controller
{
    public function get()
    {
        // Label bulan untuk grafik
        $labels = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];

        // Ambil data user per bulan
        $users = User::selectRaw('MONTH(tanggal_dibuat) as month, COUNT(*) as total')
        

            ->groupBy('month')
            ->pluck('total', 'month')
            ->toArray();

        // Ambil data produk per bulan
        $produk = Produk::selectRaw('MONTH(tanggal_dibuat) as month, COUNT(*) as total')
            ->groupBy('month')
            ->pluck('total', 'month')
            ->toArray();

        // Ambil data pembelian per bulan
        $sales = Pesanan::selectRaw('MONTH(tanggal_dibuat) as month, SUM(total_harga) as total')
            ->groupBy('month')
            ->pluck('total', 'month')
            ->toArray();

        // Inisialisasi 12 bulan data
        $usersData = $produkData = $salesData = array_fill(0, 12, 0);

        // Masukkan data sesuai bulan
        foreach ($users as $month => $count) {
            $usersData[$month - 1] = $count;
        }

        foreach ($produk as $month => $count) {
            $produkData[$month - 1] = $count;
        }

        foreach ($sales as $month => $count) {
            $salesData[$month - 1] = $count;
        }

        // Top produk untuk Revenue Sources (3 produk tertinggi)
        $topProduk = Pesanan::join('produk', 'produk.id_produk', '=', 'pesanan.id_produk')
            ->select('produk.nama_produk', DB::raw('SUM(pesanan.total_harga) as total'))
            ->groupBy('produk.nama_produk')
            ->orderByDesc('total')
            ->limit(3)
            ->get();

        return response()->json([
            'labels' => $labels,
            'usersData' => $usersData,
            'productsData' => $produkData,
            'salesData' => $salesData,
            'totalUser' => User::count(),
            'totalProduk' => Produk::count(),
            'totalPembelian' => Pesanan::sum('total_harga'),
            'revenueSources' => [
                'labels' => $topProduk->pluck('nama_produk'),
                'data' => $topProduk->pluck('total'),
            ]
        ]);
    }
}
