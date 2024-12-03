<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Barang Keluar</title>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
     
        .alert {
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            font-size: 16px;
        }
        .alert-danger {
            background-color: #f8d7da;
            border-color: #f5c6cb;
            color: #721c24;
            display: flex;
            align-items: center;
        }
        .alert-danger .icon {
            font-size: 20px;
            margin-right: 10px;
            color: #721c24;
        }
        .alert-danger ul {
            margin: 0;
            padding: 0;
            list-style: none;
        }
    </style>
</head>
<body>
    <header>
        <h1>Barang Keluar</h1>
    </header>
            @if (session('error'))
            <div class="alert alert-danger">
                <span class="icon">⚠️</span>
                {{ session('error') }}
            </div>
        @endif

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

        <!-- Form Tambah Barang Keluar -->
        <form action="{{ route('barang-keluar.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="kategori_barang" >Kategori Barang</label>
                <select id="kategori_barang" name="kategori_barang" class="form-control">
                    <option value="" disabled selected>-- Pilih Kategori --</option>
                    @foreach($barangMasuk->unique('id_kategori_barang') as $barang)
                    <option value="{{ $barang->id_kategori_barang }}">
                        {{ $barang->kategori->nama_kategori_barang }}
                    </option>
                @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="nama_barang">Nama Barang</label>
                <select id="nama_barang" name="nama_barang" class="form-control" disabled>
                    <option value="" disabled selected>Pilih Nama Barang</option>
                    @foreach($barangMasuk as $barang)
                        <option value="{{ $barang->nama_barang }}" data-kategori="{{ $barang->id_kategori_barang }}">
                            {{ $barang->nama_barang }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="jumlah_keluar" class="form-label">Jumlah Keluar</label>
                <input type="number" name="jumlah_keluar" id="jumlah_keluar" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="kondisi" class="form-label">Kondisi Barang</label>
                <select name="kondisi" id="kondisi" class="form-control" required>
                    <option value="">-- Pilih Kondisi --</option>
                    <option value="baru">Baru</option>
                    <option value="rusak">Rusak</option>
                    <option value="hilang">Hilang</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="lokasi" class="form-label">Lokasi</label>
                <select name="lokasi" id="lokasi" class="form-control" required>
                    <option value="">Pilih Lokasi</option>
                    @foreach ($lokasi as $loc)
                        <option value="{{ $loc->id_lokasi }}">{{ $loc->nama_lokasi }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="tanggal_keluar" class="form-label">Tanggal Keluar</label>
                <input type="date" name="tanggal_keluar" id="tanggal_keluar" class="form-control" required>
            </div>

            {{-- <div class="mb-3">
                <label for="tanggal_exp" class="form-label">Tanggal Expired</label>
                <input type="date" name="tanggal_exp" id="tanggal_exp" class="form-control">
            </div> --}}

            <div class="mb-3">
                <label for="nama_penanggungjawab" class="form-label">Penanggung Jawab</label>
                <input type="text" name="nama_penanggungjawab" id="nama_penanggungjawab" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>

    <footer>
        <p>&copy; {{ date('Y') }} SD Islam Tompokersan Lumajang</p>
    </footer>
    <script>
        // Ambil elemen dropdown kategori dan nama barang
        const kategoriDropdown = document.getElementById('kategori_barang');
        const namaBarangDropdown = document.getElementById('nama_barang');
    
        // Event listener untuk ketika kategori barang berubah
        kategoriDropdown.addEventListener('change', function () {
            const selectedKategori = this.value; // Ambil nilai kategori yang dipilih
    
            // Reset dropdown nama barang
            namaBarangDropdown.value = "";
            namaBarangDropdown.disabled = false;
    
            // Filter nama barang berdasarkan kategori yang dipilih
            Array.from(namaBarangDropdown.options).forEach(option => {
                if (option.dataset.kategori == selectedKategori || option.value == "") {
                    option.style.display = "block"; // Tampilkan opsi
                } else {
                    option.style.display = "none"; // Sembunyikan opsi
                }
            });
        });
    </script>
</body>
</html>
