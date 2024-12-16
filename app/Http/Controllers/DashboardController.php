<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use App\Models\KategoriBarang;
use App\Models\Lokasi;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $totalBarangMasuk = BarangMasuk::sum('jumlah_masuk');
        $totalBarangKeluar = BarangKeluar::sum('jumlah_keluar');
        $jumlahKategori = KategoriBarang::count();
        $jumlahLokasi = Lokasi::count();

        $jumlahPerKondisi = BarangMasuk::select('kondisi')
            ->selectRaw('SUM(jumlah_masuk) as total')
            ->groupBy('kondisi')
            ->get()
            ->pluck('total', 'kondisi');

        // Ambil data barang masuk, dan kelompokkan berdasarkan kategori dan nama barang
        $barangMasuk = BarangMasuk::select('id_kategori_barang', 'nama_barang')
            ->selectRaw('SUM(jumlah_masuk) as jumlah_masuk')
            ->when($search, function($query, $search){
                return $query->where('nama_barang', 'like', "%{$search}%");
            })
            ->groupBy('id_kategori_barang', 'nama_barang')
            ->get();

        // Ambil data barang keluar, dan kelompokkan berdasarkan kategori dan nama barang
        $barangKeluar = BarangKeluar::select('id_kategori_barang', 'nama_barang')
            ->selectRaw('SUM(jumlah_keluar) as jumlah_keluar')
            ->when($search, function ($query, $search) {
                return $query->where('nama_barang', 'like', "%{$search}%");
            })
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

        $stokBarang = $stokBarang->sortBy(function ($barang) {
            return $barang->kategori->nama_kategori_barang;
        });


        return view('dashboard', compact(
  'stokBarang',
 'totalBarangMasuk',
            'totalBarangKeluar',
            'jumlahKategori',
            'jumlahLokasi',
            'jumlahPerKondisi',
            'search'

        ));
    }
}