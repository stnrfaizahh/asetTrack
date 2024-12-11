<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Barang Keluar</title>
    <!-- Link ke CSS eksternal jika ada -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2>Daftar Barang Keluar</h2>
        
        <!-- Menampilkan pesan sukses -->
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Tombol untuk menambah barang keluar -->
        <div class="mb-3">
            <a href="{{ route('barang-keluar.create') }}" class="btn btn-primary">Tambah Barang Keluar</a>
            <a href="{{ route('barang-keluar.export-pdf', request()->all()) }}" class="btn btn-danger">Export PDF</a>

        <!-- Form Filter -->
        <form action="{{ route('barang-keluar.index') }}" method="GET" class="mb-3">
            <div class="row">
                <div class="col-md-3">
                    <select name="lokasi" class="form-control">
                        <option value="">Pilih Lokasi</option>
                        @foreach ($lokasi as $loc)
                            <option value="{{ $loc->id_lokasi }}" {{ request('lokasi') == $loc->id_lokasi ? 'selected' : '' }}>
                                {{ $loc->nama_lokasi }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="number" name="tahun" class="form-control" placeholder="Tahun" value="{{ request('tahun') }}">
                </div>
                <div class="col-md-3">
                    <select name="bulan" class="form-control">
                        <option value="">Pilih Bulan</option>
                        @for ($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}" {{ request('bulan') == $i ? 'selected' : '' }}>
                                {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                            </option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary">Filter</button>
                    <a href="{{ route('barang-keluar.index') }}" class="btn btn-secondary">Reset</a>
                </div>
            </div>
        </form>

        </div>

        <!-- Tabel Daftar Barang Keluar -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kategori Barang</th>
                    <th>Nama Barang</th>
                    <th>Jumlah Keluar</th>
                    <th>Kondisi</th>
                    <th>Lokasi</th>
                    <th>Tanggal Keluar</th>
                    <th>Tanggal Expired</th>
                    <th>Penanggung Jawab</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($barangKeluar as $item)
                    <tr>
                        <td>{{ ($barangKeluar->currentPage() - 1) * $barangKeluar->perPage() + $loop->iteration }}</td>
                        <td>{{ $item->kategori->nama_kategori_barang }}</td>
                        <td>{{ $item->nama_barang }}</td>
                        <td>{{ $item->jumlah_keluar }}</td>
                        <td>{{ ucfirst($item->kondisi) }}</td>
                        <td>{{ $item->lokasi->nama_lokasi }}</td>
                        <td>{{ $item->tanggal_keluar }}</td>
                        <td>{{ $item->tanggal_exp }}</td>
                        <td>{{ $item->nama_penanggungjawab }}</td>
                        <td>
                            <a href="{{ route('barang-keluar.edit', $item->id_barang_keluar) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('barang-keluar.destroy', $item->id_barang_keluar) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus barang ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="text-center">Data barang keluar tidak tersedia.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="d-flex justify-content-center">
            {{ $barangKeluar->links() }}
        </div>
    </div>

    <footer>
        <p>&copy; {{ date('Y') }} Sekolah XYZ</p>
    </footer>
</body>

<script>
    document.getElementById('exportPdfBtn').addEventListener('click', function() {
        document.getElementById('filterForm').classList.remove('d-none');
    });

    document.getElementById('cancelFilterBtn').addEventListener('click', function() {
        document.getElementById('filterForm').classList.add('d-none');
    });
</script>

</html>
