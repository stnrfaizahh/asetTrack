@extends('layouts.app')

@section('content')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("SELAMAT DATANG ADMIN") }}
                </div>
                  {{-- Statistik --}}
                  <div class="row mt-4">
                    <div class="col-md-3">
                        <div class="card bg-primary text-white">
                            <div class="card-body">
                                <h5>Total Barang Masuk</h5>
                                <h2>{{ $totalBarangMasuk }}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-success text-white">
                            <div class="card-body">
                                <h5>Total Barang Keluar</h5>
                                <h2>{{ $totalBarangKeluar }}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-warning text-dark">
                            <div class="card-body">
                                <h5>Jumlah Kategori Barang</h5>
                                <h2>{{ $jumlahKategori }}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-info text-white">
                            <div class="card-body">
                                <h5>Jumlah Lokasi</h5>
                                <h2>{{ $jumlahLokasi }}</h2>
                            </div>
                        </div>
                    </div>
                </div>


                 {{-- Statistik Berdasarkan Kondisi --}}
                 <div class="row mt-4">
                    <div class="col-md-4">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h5>Kondisi: Baru</h5>
                                <h2>{{ $jumlahPerKondisi['Baru'] ?? 0 }}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h5>Kondisi: Diperbaiki</h5>
                                <h2>{{ $jumlahPerKondisi['Diperbaiki'] ?? 0 }}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h5>Kondisi: Rusak</h5>
                                <h2>{{ $jumlahPerKondisi['Rusak'] ?? 0 }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-lg-center mb-3">
            <h1 class="mb-4">Detail Stok Barang</h1>
            <link rel="stylesheet" href="{{ asset('css/app.css') }}"> {{-- Include CSS --}}
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

        <form action="{{ route('dashboard') }}" method="GET" class="form-inline">
            <input type="text" name="search" class="form-control mr-2" placeholder="Cari barang..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-secondary">Cari</button>
        </form>

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