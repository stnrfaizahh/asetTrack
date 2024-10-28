<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Barang Masuk</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}"> {{-- Include CSS --}}
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h1>Daftar Barang Masuk</h1>
        
        {{-- Pesan sukses setelah melakukan tindakan --}}
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        {{-- Tombol untuk menambah barang baru --}}
        <a href="{{ route('barang-masuk.create') }}" class="btn btn-primary mb-3">Tambah Barang Masuk</a>

        {{-- Tabel daftar barang masuk --}}
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kategori Barang</th>
                    <th>Nama Barang</th>
                    <th>Sumber Barang</th>
                    <th>Jumlah Masuk</th>
                    <th>Kondisi</th>
                    <th>Lokasi</th>
                    <th>Tanggal Masuk</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($barangMasuk as $barang)
                    <tr>
                        {{-- Menampilkan kode barang (id_barang_masuk) --}}
                        <td>{{ $barang->id_barang_masuk }}</td>

                        {{-- Menampilkan nama kategori barang --}}
                        <td>{{ $barang->kategori->nama_kategori_barang }}</td>

                        {{-- Menampilkan nama barang --}}
                        <td>{{ $barang->nama_barang }}</td>

                        {{-- Menampilkan sumber barang --}}
                        <td>{{ $barang->sumber_barang }}</td>

                        {{-- Menampilkan jumlah barang masuk --}}
                        <td>{{ $barang->jumlah_masuk }}</td>

                        {{-- Menampilkan kondisi barang --}}
                        <td>{{ $barang->kondisi }}</td>

                        {{-- Menampilkan nama lokasi --}}
                        <td>{{ $barang->lokasi->nama_lokasi }}</td>

                        {{-- Menampilkan tanggal masuk --}}
                        <td>{{ \Carbon\Carbon::parse($barang->tanggal_masuk)->format('d-m-Y') }}</td>


                        {{-- Aksi untuk Edit atau Hapus --}}
                        <td>
                            <a href="{{ route('barang-masuk.edit', $barang->id_barang_masuk) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('barang-masuk.destroy', $barang->id_barang_masuk) }}" method="POST" style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus barang ini?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center">Belum ada data barang masuk.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <script src="{{ asset('js/app.js') }}"></script> {{-- Include JS jika diperlukan --}}
</body>
</html>
