@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Daftar Lokasi</h1>

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('lokasi.create') }}" class="btn btn-primary">Tambah Lokasi</a>
    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Lokasi</th>
                <th>Nama Lokasi</th>
              
            </tr>
        </thead>
        <tbody>
            @foreach ($lokasi as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->kode_lokasi }}</td>
                    <td>{{ $item->nama_lokasi }}</td>
                    <td>
                        <a href="{{ route('lokasi.edit', $item->id_lokasi) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('lokasi.destroy', $item->id_lokasi) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection