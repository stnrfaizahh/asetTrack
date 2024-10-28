<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BarangMasuk;
use App\Models\KategoriBarang;
use App\Models\Lokasi;
use App\Models\Barang; // Tambahkan ini jika ada tabel `barang` untuk stok total

class BarangMasukController extends Controller
{
    public function create()
    {
        $kategori_barang = KategoriBarang::all();
        $lokasi = Lokasi::all();
        return view('admin.barang_masuk.create', compact('kategori_barang', 'lokasi'));
    }

    // Menyimpan data barang masuk
    public function store(Request $request)
    {
        $request->validate([
            'kategori_barang' => 'required|exists:kategori_barang,id_kategori_barang',
            'nama_barang' => 'required|string|max:255',
            'sumber_barang' => 'required|string|max:255',
            'jumlah_masuk' => 'required|integer|min:1',
            'kondisi' => 'required|string',
            'lokasi' => 'required|exists:lokasi,id_lokasi',
            'tanggal_masuk' => 'required|date',
        ]);

        // Generate kode barang masuk
        $kodeBarang = $this->generateBarangMasukId($request);

        // Buat entri baru setiap kali ada input
        BarangMasuk::create([
            'kode_barang' => $kodeBarang,
            'id_kategori_barang' => $request->kategori_barang,
            'nama_barang' => $request->nama_barang,
            'sumber_barang' => $request->sumber_barang,
            'jumlah_masuk' => $request->jumlah_masuk,
            'kondisi' => $request->kondisi,
            'id_lokasi' => $request->lokasi,
            'tanggal_masuk' => $request->tanggal_masuk,
        ]);

        return redirect()->route('barang-masuk.index')->with('success', 'Barang masuk berhasil ditambahkan.');
    }

    private function generateBarangMasukId(Request $request)
    {
        // Cari apakah barang sudah pernah masuk berdasarkan kategori dan nama barang
        $existingBarangMasuk = BarangMasuk::where('id_kategori_barang', $request->kategori_barang)
            ->where('nama_barang', $request->nama_barang)
            ->first();

        if ($existingBarangMasuk) {
            // Jika barang sudah ada, gunakan kembali kode barang yang sama
            $kode_barang = $existingBarangMasuk->kode_barang;
        } else {
            // Jika barang belum ada, buat kode barang baru
            $lastBarang = BarangMasuk::where('id_kategori_barang', $request->kategori_barang)
                ->orderBy('kode_barang', 'desc')
                ->first();

            $newNumber = 1;

            if ($lastBarang) {
                // Dapatkan angka dari kode barang terakhir dan tambahkan 1
                $newNumber = intval(substr($lastBarang->kode_barang, -3)) + 1;
            }

            // Ambil kode kategori dari kategori_barang yang dipilih
            $kategori = KategoriBarang::find($request->kategori_barang);

            // Buat kode barang baru dengan format kategori + 3 digit angka
            $kode_barang = strtoupper($kategori->kode_kategori) . sprintf("%03d", $newNumber);
        }
        return $kode_barang;
    }


    public function index()
    {
        // Ambil semua data barang masuk dari database
        $barangMasuk = BarangMasuk::with(['kategori', 'lokasi'])->get();

        // Return view dan kirim data barang masuk ke view
        return view('admin.barang_masuk.index', compact('barangMasuk'));
    }
}