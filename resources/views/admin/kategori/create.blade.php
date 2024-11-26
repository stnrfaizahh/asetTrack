@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Tambah Kategori</h1>
    <form action="{{ route('kategori.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="kode_kategori" class="form-label">Kode Kategori</label>
            <input type="text" name="kode_kategori" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="nama_kategori_barang" class="form-label">Nama Kategori</label>
            <input type="text" name="nama_kategori_barang" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection
