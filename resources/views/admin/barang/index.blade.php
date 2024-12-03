@extends('admin.admin')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-lg-center mb-3">
        <h1 class="mb-4">Detail Stok Barang</h1>
        <link rel="stylesheet" href="{{ asset('css/app.css') }}"> {{-- Include CSS --}}
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    </div>
    
    <table class="table table-bordered table-striped table-hover" style="border: 1px solid #333;">
        <thead class="table-light">
            <tr>
                <th rowspan="2" class="text-center align-middle">No</th>
                <th rowspan="2" class="text-center align-middle">Kategori</th>
                <th rowspan="2" class="text-center align-middle">Nama Barang</th>
                <th rowspan="2" class="text-center align-middle">Jumlah Masuk</th>
                <th rowspan="2" class="text-center align-middle">Jumlah Keluar</th>
                <th rowspan="2" class="text-center align-middle">Stok</th>
            </tr>
            
        </thead>
        <tbody>
            @php
                $currentKategori = null;
                $counter = 1;
            @endphp

            @foreach ($stokBarang as $index => $barang)
                <tr>
                     <td class="text-center">{{ $counter++ }}</td> 
                    <td>{{ $barang->kategori->nama_kategori_barang }}</td>
                    <td>{{ $barang->nama_barang }}</td>
                    <td class="text-center">{{ $barang->jumlah_masuk }}</td>
                    <td class="text-center">{{ $barang->jumlah_keluar }}</td>
                    <td class="text-center">{{ $barang->stok }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
