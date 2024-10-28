@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Detail Barang: {{ $barang->nama_barang }}</h1>
    <div class="card">
        <div class="card-body">
            <h4>Informasi Barang</h4>
            <p><strong>Kode Barang:</strong> {{ $barang->kode_barang }}</p>
            <p><strong>Nama Barang:</strong> {{ $barang->nama_barang }}</p>
            <p><strong>Kategori:</strong> {{ $barang->kategori->nama_kategori }}</p>
            <p><strong>Stok Saat Ini:</strong> {{ $stokAkhir }}</p>
            <p><strong>Total Barang Masuk:</strong> {{ $totalMasuk }}</p>
            <p><strong>Total Barang Keluar:</strong> {{ $totalKeluar }}</p>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-body">
            <h4>Riwayat Barang Masuk</h4>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Tanggal Masuk</th>
                        <th>Jumlah Masuk</th>
                        <th>Sumber Barang</th>
                        <th>Lokasi</th>
                        <th>Kondisi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($barangMasuk as $masuk)
                        <tr>
                            <td>{{ $masuk->tanggal_masuk }}</td>
                            <td>{{ $masuk->jumlah_masuk }}</td>
                            <td>{{ $masuk->sumber_barang }}</td>
                            <td>{{ $masuk->lokasi->nama_lokasi }}</td>
                            <td>{{ $masuk->kondisi }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-body">
            <h4>Riwayat Barang Keluar</h4>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Tanggal Keluar</th>
                        <th>Jumlah Keluar</th>
                        <th>Tujuan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($barangKeluar as $keluar)
                        <tr>
                            <td>{{ $keluar->tanggal_keluar }}</td>
                            <td>{{ $keluar->jumlah_keluar }}</td>
                            <td>{{ $keluar->tujuan }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
