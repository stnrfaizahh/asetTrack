<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laporan Inventaris</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid black;
            padding: 5px;
            text-align: center;
        }
        .kop-surat {
            text-align: center;
            margin-bottom: 20px;
        }
        .ttd {
            margin-top: 50px;
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="kop-surat">
        <h2>SDN 01 Contoh</h2>
        <p>Alamat: Jl. Pendidikan No. 1, Kota Pelajar</p>
        <h4>Laporan Inventaris Barang</h4>
        <p>Periode: {{ $periode_bulan }}/{{ $periode_tahun }}</p>
        <p>Lokasi: {{ $lokasi }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Kategori Barang</th>
                <th>Nama Barang</th>
                <th>Jumlah Masuk</th>
                <th>Jumlah Keluar</th>
                <th>Stok Akhir</th>
                <th>Kondisi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($barang as $item)
                <tr>
                    <td>{{ $item['kategori_barang'] }}</td>
                    <td>{{ $item['nama_barang'] }}</td>
                    <td>{{ $item['jumlah_masuk'] }}</td>
                    <td>{{ $item['jumlah_keluar'] }}</td>
                    <td>{{ $item['stok_akhir'] }}</td>
                    <td>{{ $item['kondisi'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="ttd">
        <p>Mengetahui,</p>
        <p>Kepala Sekolah</p>
        <br><br>
        <p>{{ $nama_kepala_sekolah }}</p>
    </div>
</body>
</html>
