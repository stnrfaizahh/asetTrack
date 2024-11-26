@extends('layouts.app')

@section('content')
    <h1>Edit Lokasi</h1>
    <form method="POST" action="{{ route('lokasi.update', $lokasi->id_lokasi) }}">
        @csrf
        @method('PUT')

        <div>
            <label for="kode_lokasi">Kode Lokasi:</label>
            <input type="text" id="kode_lokasi" name="kode_lokasi" value="{{ $lokasi->kode_lokasi }}" required>
        </div>

        <div>
            <label for="nama_lokasi">Nama Lokasi:</label>
            <input type="text" id="nama_lokasi" name="nama_lokasi" value="{{ $lokasi->nama_lokasi }}" required>
        </div>

        <button type="submit">Update</button>
    </form>
@endsection
