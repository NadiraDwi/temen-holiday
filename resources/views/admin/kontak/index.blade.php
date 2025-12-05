@extends('admin.layouts')

@section('title', 'Kelola Kontak')

@section('content')
<style>
    .table thead th {
        background: #1e293b !important; /* dark slate */
        color: #fff !important;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: .5px;
    }
</style>

<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <h4>Kelola Kontak</h4>
            </div>
        </div>
    </div>
</div>

<div class="card p-4 shadow-sm">

    {{-- Tombol Tambah --}}
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addModal">
        + Tambah Kontak
    </button>

    {{-- Tabel Kontak --}}
    <div class="table-responsive">
        <table class="table table-bordered text-center">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>No HP</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($contacts as $i => $c)
                <tr>
                    <td>{{ $i+1 }}</td>
                    <td>{{ $c->nama }}</td>
                    <td>{{ $c->no_hp }}</td>
                    <td>
                        <button class="btn btn-warning btn-sm"
                                data-bs-toggle="modal"
                                data-bs-target="#editModal{{ $c->id_contact }}">
                            Edit
                        </button>

                        <form action="{{ route('kontak.destroy', $c->id_contact) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Hapus kontak ini?')" class="btn btn-danger btn-sm">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>

{{-- ========================================================= --}}
{{-- ===============  SEMUA MODAL DITEMPATKAN DI BAWAH  ======= --}}
{{-- ========================================================= --}}

{{-- Modal Tambah --}}
<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('kontak.store') }}" class="modal-content">
            @csrf

            <div class="modal-header">
                <h5 class="modal-title">Tambah Kontak</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="mb-3">
                    <label>Nama</label>
                    <input type="text" name="nama" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>No HP</label>
                    <input type="text" name="no_hp" class="form-control" required>
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

{{-- Modal Edit untuk setiap kontak --}}
@foreach ($contacts as $c)
<div class="modal fade" id="editModal{{ $c->id_contact }}" tabindex="-1">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('kontak.update', $c->id_contact) }}" class="modal-content">
            @csrf
            @method('PUT')

            <div class="modal-header">
                <h5 class="modal-title">Edit Kontak</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="mb-3">
                    <label>Nama</label>
                    <input type="text" name="nama" value="{{ $c->nama }}" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>No HP</label>
                    <input type="text" name="no_hp" value="{{ $c->no_hp }}" class="form-control" required>
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endforeach

@endsection
