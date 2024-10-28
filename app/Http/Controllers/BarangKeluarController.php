<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BarangKeluar;
use App\Models\BarangMasuk;
use App\Models\KategoriBarang;
use App\Models\Lokasi;
use Carbon\Carbon;

class BarangKeluarController extends Controller
{
    public function create()
    {
        $kategori_barang = KategoriBarang::all(); // Ambil semua kategori barang
        $lokasi = Lokasi::all(); // Ambil semua lokasi

        return view('admin.barang_keluar.create', compact('kategori_barang', 'lokasi'));
    }

    // Menyimpan data barang keluar
    public function store(Request $request)
    {
        $request->validate([
            'kategori_barang' => 'required|exists:kategori_barang,id_kategori_barang',
            'nama_barang' => 'required|string',
            'jumlah_keluar' => 'required|integer',
            'kondisi' => 'required',
            'lokasi' => 'required|exists:lokasi,id_lokasi',
            'tanggal_keluar' => 'required|date',
            'nama_penanggungjawab' => 'required|string',
        ]);
        // cek barang apa tersedia di tabel barang masuk
        $barangMasuk = BarangMasuk::where('id_kategori_barang', $request->kategori_barang)
            ->where('nama_barang', $request->nama_barang)
            ->first();

        if (!$barangMasuk) {
            return redirect()->back()->with('error', 'Barang yang dimaksud tidak ditemukan di stok masuk.');
        }

        // Cek apakah stok cukup
        if ($barangMasuk->jumlah_masuk < $request->jumlah_keluar) {
            return redirect()->back()->with('error', 'Jumlah barang keluar melebihi stok yang tersedia.');
        }

        $tanggalExp = Carbon::parse($request->tanggal_keluar)->addYears(3);
        
        // Simpan data barang keluar
        BarangKeluar::create([
            'id_kategori_barang' => $request->kategori_barang,
            'nama_barang' => $request->nama_barang,
            'jumlah_keluar' => $request->jumlah_keluar,
            'kondisi' => $request->kondisi,
            'id_lokasi' => $request->lokasi,
            'tanggal_keluar' => $request->tanggal_keluar,
            'tanggal_exp' => $tanggalExp,
            'nama_penanggungjawab' => $request->nama_penanggungjawab,
        ]);
        // Update stok
        $barangMasuk->jumlah_masuk -= $request->jumlah_keluar;
        $barangMasuk->save();

        return redirect()->route('barang-keluar.index')->with('success', 'Barang keluar berhasil ditambahkan dan stok diperbarui.');
    }
    public function index()
    {
        // Ambil semua data barang keluar dengan relasi kategori dan lokasi
        $barangKeluar = BarangKeluar::with(['kategori', 'lokasi'])->paginate(10); // Misalnya menggunakan pagination 10 data per halaman

        return view('admin.barang_keluar.index', compact('barangKeluar'));
    }
}