@extends('layouts.app')

@section('content')
    <h1>Edit Kategori</h1>
    <form method="POST" action="{{ route('kategori.update', $kategori->id_kategori_barang) }}">
        @csrf
        @method('PUT')

        <div>
            <label for="kode_kategori">Kode Kategori:</label>
            <input type="text" id="kode_kategori" name="kode_kategori" value="{{ $kategori->kode_kategori }}" required>
        </div>

        <div>
            <label for="nama_kategori_barang">Nama Kategori:</label>
            <input type="text" id="nama_kategori_barang" name="nama_kategori_barang" value="{{ $kategori->nama_kategori_barang }}" required>
        </div>

        <button type="submit">Update</button>
    </form>
@endsection
