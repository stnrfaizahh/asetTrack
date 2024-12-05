<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Barang Keluar</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <header>
        <h1>Edit Barang Keluar</h1>
    </header>

    <div class="container">
        <!-- Menampilkan pesan error -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <span class="icon">⚠️</span>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form Edit Barang Keluar -->
        <form action="{{ route('barang-keluar.update', $barangKeluar->id_barang_keluar) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="kategori_barang" class="form-label">Kategori Barang</label>
                <select name="kategori_barang" id="kategori_barang" class="form-control" required>
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($kategori_barang as $kategori)
                        <option value="{{ $kategori->id_kategori_barang }}" {{ $barangKeluar->id_kategori_barang == $kategori->id_kategori_barang ? 'selected' : '' }}>
                            {{ $kategori->nama_kategori_barang }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="nama_barang" class="form-label">Nama Barang</label>
                <input type="text" name="nama_barang" id="nama_barang" class="form-control" value="{{ $barangKeluar->nama_barang }}" required>
            </div>

            <div class="mb-3">
                <label for="jumlah_keluar" class="form-label">Jumlah Keluar</label>
                <input type="number" name="jumlah_keluar" id="jumlah_keluar" class="form-control" value="{{ $barangKeluar->jumlah_keluar }}" required>
            </div>

            <div class="mb-3">
                <label for="kondisi" class="form-label">Kondisi Barang</label>
                <select name="kondisi" id="kondisi" class="form-control" required>
                    <option value="">-- Pilih Kondisi --</option>
                    <option value="baru" {{ $barangKeluar->kondisi == 'baru' ? 'selected' : '' }}>Baru</option>
                    <option value="rusak" {{ $barangKeluar->kondisi == 'rusak' ? 'selected' : '' }}>Rusak</option>
                    <option value="hilang" {{ $barangKeluar->kondisi == 'hilang' ? 'selected' : '' }}>Hilang</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="lokasi" class="form-label">Lokasi</label>
                <select name="lokasi" id="lokasi" class="form-control" required>
                    <option value="">Pilih Lokasi</option>
                    @foreach ($lokasi as $loc)
                        <option value="{{ $loc->id_lokasi }}" {{ $barangKeluar->id_lokasi == $loc->id_lokasi ? 'selected' : '' }}>
                            {{ $loc->nama_lokasi }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="tanggal_keluar" class="form-label">Tanggal Keluar</label>
                <input type="date" name="tanggal_keluar" id="tanggal_keluar" class="form-control" value="{{ $barangKeluar->tanggal_keluar }}" required>
            </div>

            <div class="mb-3">
                <label for="masa_pakai" class="form-label"> Masa Pakai (dalam bulan)</label>
                <input type="number" name="masa_pakai" id="masa_pakai" class="form-control" value="{{ old('masa_pakai', $barangKeluar->masa_pakai) }}" required>
            </div>
            

            <div class="mb-3">
                <label for="nama_penanggungjawab" class="form-label">Penanggung Jawab</label>
                <input type="text" name="nama_penanggungjawab" id="nama_penanggungjawab" class="form-control" value="{{ $barangKeluar->nama_penanggungjawab }}" required>
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('barang-keluar.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>

    <footer>
        <p>&copy; {{ date('Y') }} Sekolah XYZ</p>
    </footer>
</body>
</html>
