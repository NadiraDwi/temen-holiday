@extends('admin.layouts')

@section('title', 'Tambah Kendaraan')

@section('content')

<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.kendaraan.index') }}">Kendaraan</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Tambah</a></li>
                </ul>
            </div>
            <div class="col-md-12">
                <div class="page-header-title">
                    <h2 class="mb-0">Tambah Kendaraan</h2>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- FORM TAMBAH KENDARAAN -->
<div class="row">
    <div class="col-md-10 mx-auto">
        <div class="card">
            <div class="card-body">

                <form action="{{ route('admin.kendaraan.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Nama -->
                    <div class="mb-3">
                        <label class="form-label">Nama Kendaraan</label>
                        <input type="text" name="nama_kendaraan" class="form-control" required>
                    </div>

                    <!-- Kapasitas -->
                    <div class="mb-3">
                        <label class="form-label">Kapasitas (Orang)</label>
                        <input type="number" name="kapasitas" class="form-control" required>
                    </div>

                    <!-- Fasilitas -->
                    <div class="mb-3">
                        <label class="form-label">Fasilitas</label>
                        <textarea name="fasilitas" class="form-control" rows="3" required></textarea>
                    </div>

                    <!-- Harga -->
                    <div class="mb-3">
                        <label class="form-label">Harga</label>
                        <input type="number" name="harga" class="form-control" required>
                    </div>

                    <!-- Kontak (Opsional) -->
                    <div class="mb-3">
                        <label class="form-label">Kontak</label>
                        <select name="id_contact" class="form-select" required>
                            <option value="">-- Pilih Kontak --</option>
                            @foreach ($contacts as $c)
                                <option value="{{ $c->id_contact }}">{{ $c->nama }} ({{ $c->no_hp }})</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Gambar -->
                    <div class="mb-3">
                        <label class="form-label">Gambar Kendaraan</label>
                        <input type="file" name="gambar" class="form-control" accept="image/*">
                    </div>

                    <div class="text-end">
                        <a href="{{ route('admin.kendaraan.index') }}" class="btn btn-secondary">Kembali</a>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>

@endsection
