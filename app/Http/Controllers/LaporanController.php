<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use App\Models\KategoriBarang;
use App\Models\Lokasi;
use App\Models\Admin;
use PDF; 
use Carbon\Carbon;

class LaporanController extends Controller
{
    // Menampilkan halaman untuk memilih periode dan lokasi
    public function create()
    {
        $lokasi = Lokasi::all(); // Ambil semua lokasi (kelas)
        return view('admin.laporan.create', compact('lokasi'));
    }

    // Membuat dan menyimpan laporan
    public function store(Request $request)
    {
        $request->validate([
            'periode_bulan' => 'required',
            'periode_tahun' => 'required',
            'lokasi' => 'required|exists:lokasi,id_lokasi'
        ]);

        // Ambil data barang yang sesuai dengan periode dan lokasi
        $barangMasuk = BarangMasuk::whereMonth('tanggal_masuk', $request->periode_bulan)
            ->whereYear('tanggal_masuk', $request->periode_tahun)
            ->where('lokasi', $request->lokasi)
            ->get();

        $barangKeluar = BarangKeluar::whereMonth('tanggal_keluar', $request->periode_bulan)
            ->whereYear('tanggal_keluar', $request->periode_tahun)
            ->where('lokasi', $request->lokasi)
            ->get();

        // Kalkulasi stok berdasarkan barang masuk dan barang keluar
        $stokBarang = $this->calculateStock($barangMasuk, $barangKeluar);

        // Data untuk laporan
        $data = [
            'periode_bulan' => $request->periode_bulan,
            'periode_tahun' => $request->periode_tahun,
            'lokasi' => Lokasi::find($request->lokasi)->nama_lokasi, 
            'admin' => Auth::user()->nama, 
            'tanggal_cetak' => Carbon::now()->format('d-m-Y'),
            'barang' => $stokBarang
        ];

       // Generate PDF
        $pdf = PDF::loadView('admin.laporan.pdf', $data);

        // Simpan file laporan ke database atau folder
        $fileName = 'laporan_inventaris_' . $request->periode_bulan . '_' . $request->periode_tahun . '.pdf';
        $pdf->save(public_path('laporan/' . $fileName));

        // Redirect atau tampilkan hasil cetak
        return $pdf->download($fileName); // Untuk download file
        // return view('admin.laporan.show', compact('data')); // Untuk melihat di browser
    }

    // Fungsi untuk kalkulasi stok
    private function calculateStock($barangMasuk, $barangKeluar)
    {
        // Buat array untuk menyimpan hasil stok per barang
        $stokBarang = [];

        foreach ($barangMasuk as $masuk) {
            // Hitung jumlah barang keluar untuk barang yang sama
            $keluar = $barangKeluar->where('nama_barang', $masuk->nama_barang)->sum('jumlah_keluar');

            // Hitung stok barang
            $stokBarang[] = [
                'kategori_barang' => $masuk->kategori_barang,
                'nama_barang' => $masuk->nama_barang,
                'jumlah_masuk' => $masuk->jumlah_masuk,
                'jumlah_keluar' => $keluar,
                'stok_akhir' => $masuk->jumlah_masuk - $keluar,
                'kondisi' => $masuk->kondisi,
                'lokasi' => $masuk->lokasi
            ];
        }

        return $stokBarang;
    }
}