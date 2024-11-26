@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Tambah Lokasi</h1>
    <form action="{{ route('lokasi.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="kode_lokasi" class="form-label">Kode Lokasi</label>
            <input type="text" name="kode_lokasi" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="nama_lokasi" class="form-label">Nama Lokasi</label>
            <input type="text" name="nama_lokasi" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection
