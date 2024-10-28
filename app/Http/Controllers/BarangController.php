<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
class BarangController extends Controller
{
     public function index()
     {
        $barangMasuk = BarangMasuk::with(['kategori', 'lokasi'])->get();
        
        // Mengambil data barang keluar dengan join ke kategori dan lokasi
        $barangKeluar = BarangKeluar::with(['kategori', 'lokasi'])->get();
        
        $barang = $barangMasuk->map(function($item) use ($barangKeluar) {
            $keluar = $barangKeluar->where('nama_barang', $item->nama_barang)->sum('jumlah_keluar');
            $item->stok = $item->jumlah_masuk - $keluar;
            return $item;
        });
 
         return view('admin.barang.index', compact('barang'));
     }
 
     // Menampilkan detail barang tertentu
     public function show($id)
     {
        $barangMasuk = BarangMasuk::with(['kategori', 'lokasi'])->findOrFail($id);
        $barangKeluar = BarangKeluar::where('nama_barang', $barangMasuk->nama_barang)->sum('jumlah_keluar');

        $stok = $barangMasuk->jumlah_masuk - $barangKeluar;

        return view('admin.barang.show', compact('barangMasuk', 'stok'));
     }
     public function showDetail($kode_barang)
{
    // Ambil data barang pertama dengan kode_barang yang sesuai
    $barang = BarangMasuk::where('kode_barang', $kode_barang)->first();

    if (!$barang) {
        return redirect()->route('barang-masuk.index')->with('error', 'Barang tidak ditemukan');
    }

    // Ambil semua riwayat barang masuk dan keluar berdasarkan kode_barang
    $barangMasuk = BarangMasuk::where('kode_barang', $kode_barang)->get();
    $barangKeluar = BarangKeluar::where('kode_barang', $kode_barang)->get();

    // Hitung total masuk dan total keluar
    $totalMasuk = $barangMasuk->sum('jumlah_masuk');
    $totalKeluar = $barangKeluar->sum('jumlah_keluar');

    // Hitung stok akhir
    $stokAkhir = $totalMasuk - $totalKeluar;

    return view('admin.barang.detail', compact('barang', 'barangMasuk', 'barangKeluar', 'totalMasuk', 'totalKeluar', 'stokAkhir'));
}

}