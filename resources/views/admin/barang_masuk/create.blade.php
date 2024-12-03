<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Barang Masuk</title>
    {{-- Include CSS atau file lain jika diperlukan --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}"> {{-- Sesuaikan jika menggunakan CSS --}}
</head>
<body>
    <div class="container">
        <h1>Tambah Barang Masuk</h1>
        
        {{-- Menampilkan pesan error jika ada --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Form input untuk menambah barang masuk --}}
        <form action="{{ route('barang-masuk.store') }}" method="POST">
            @csrf
            
            {{-- Kategori Barang --}}
            <div class="form-group">
                <label for="kategori_barang">Kategori Barang</label>
                <select name="kategori_barang" id="kategori_barang" class="form-control">
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($kategori_barang as $kategori)
                    <option value="{{ $kategori->id_kategori_barang }}">{{ $kategori->nama_kategori_barang }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Nama Barang --}}
            <div class="form-group">
                <label for="nama_barang">Nama Barang</label>
                <input type="text" name="nama_barang" id="nama_barang" class="form-control" value="{{ old('nama_barang') }}" required>
            </div>

            {{-- Sumber Barang --}}
            <div class="form-group">
                <label for="sumber_barang">Sumber Dana</label>
                <input type="text" name="sumber_barang" id="sumber_barang" class="form-control" value="{{ old('sumber_barang') }}" required>
            </div>

            {{-- Jumlah Barang Masuk --}}
            <div class="form-group">
                <label for="jumlah_masuk">Jumlah Masuk</label>
                <input type="number" name="jumlah_masuk" id="jumlah_masuk" class="form-control" value="{{ old('jumlah_masuk') }}" required>
            </div>

            {{-- Kondisi Barang --}}
            <div class="form-group">
                <label for="kondisi">Kondisi Barang</label>
                <select name="kondisi" id="kondisi" class="form-control" required>
                    <option value="">-- Pilih Kondisi --</option>
                    <option value="Baru">Baru</option>
                    <option value="Rusak">Rusak</option>
                    <option value="Diperbaiki">Diperbaiki</option>
                </select>
            </div>

            {{-- Lokasi --}}
            <div class="form-group">
                <label for="lokasi">Lokasi</label>
                <select name="lokasi" id="lokasi" class="form-control" required>
                    <option value="">-- Pilih Lokasi --</option>
                    @foreach($lokasi as $lok)
                        <option value="{{ $lok->id_lokasi }}">{{ $lok->nama_lokasi }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Tanggal Masuk --}}
            <div class="form-group">
                <label for="tanggal_masuk">Tanggal Masuk</label>
                <input type="date" name="tanggal_masuk" id="tanggal_masuk" class="form-control" value="{{ old('tanggal_masuk') }}" required>
            </div>

            {{-- Tombol Submit --}}
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>

    {{-- Include JS atau file lain jika diperlukan --}}
    <script src="{{ asset('js/app.js') }}"></script> {{-- Sesuaikan jika menggunakan JavaScript --}}
</body>
</html>
