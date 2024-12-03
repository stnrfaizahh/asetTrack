<?php

namespace App\Http\Controllers;

use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use App\Models\KategoriBarang;
use App\Models\Lokasi;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Hitung total barang masuk
        $totalBarangMasuk = BarangMasuk::sum('jumlah_masuk');

        // Hitung total barang keluar
        $totalBarangKeluar = BarangKeluar::sum('jumlah_keluar');

        // Hitung total kategori barang
        $totalKategori = KategoriBarang::count();

        // Hitung total lokasi
        $totalLokasi = Lokasi::count();

        // Ambil data kondisi barang
        $kondisiBarang = DB::table('barang')
            ->select('kondisi', DB::raw('COUNT(*) as jumlah'))
            ->groupBy('kondisi')
            ->get();

        // Data untuk grafik barang masuk (kelompokkan berdasarkan bulan)
        $barangMasukPerBulan = BarangMasuk::selectRaw('MONTH(tanggal_masuk) as bulan, SUM(jumlah_masuk) as total')
            ->groupByRaw('MONTH(tanggal_masuk)')
            ->orderByRaw('MONTH(tanggal_masuk)')
            ->get();

        return view('admin.dashboard.index', compact(
            'totalBarangMasuk',
            'totalBarangKeluar',
            'totalKategori',
            'totalLokasi',
            'kondisiBarang',
            'barangMasukPerBulan'
        ));
        // Ambil data barang masuk, dan kelompokkan berdasarkan kategori dan nama barang
        $barangMasuk = BarangMasuk::select('id_kategori_barang', 'nama_barang')
            ->selectRaw('SUM(jumlah_masuk) as jumlah_masuk')
            ->groupBy('id_kategori_barang', 'nama_barang')
            ->get();

        // Ambil data barang keluar, dan kelompokkan berdasarkan kategori dan nama barang
        $barangKeluar = BarangKeluar::select('id_kategori_barang', 'nama_barang')
            ->selectRaw('SUM(jumlah_keluar) as jumlah_keluar')
            ->groupBy('id_kategori_barang', 'nama_barang')
            ->get();

        // Gabungkan data barang masuk dan barang keluar
        $stokBarang = $barangMasuk->map(function ($barang) use ($barangKeluar) {
            $keluar = $barangKeluar->where('id_kategori_barang', $barang->id_kategori_barang)
                ->where('nama_barang', $barang->nama_barang)
                ->first();

            $barang->jumlah_keluar = $keluar ? $keluar->jumlah_keluar : 0;
            $barang->stok = $barang->jumlah_masuk - $barang->jumlah_keluar;

            return $barang;
        });

        return view('dashboard', compact('stokBarang'));
    }
}
