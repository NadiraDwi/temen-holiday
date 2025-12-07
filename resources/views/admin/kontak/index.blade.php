@extends('admin.layouts')

@section('title', 'Kelola Kontak')

@section('content')

<div class="page-header mb-3">
    <h4>Kelola Kontak</h4>
</div>

{{-- ALERT SUCCESS --}}
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

{{-- ALERT ERROR ADD --}}
@if($errors->any() && old('form') == 'add')
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    @if($errors->has('nama'))
        {{ $errors->first('nama') }}
    @elseif($errors->has('no_hp'))
        {{ $errors->first('no_hp') }}
    @else
        Periksa kembali data yang Anda masukkan.
    @endif
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>

<script>
    new bootstrap.Modal(document.getElementById('addModal')).show();
</script>
@endif

{{-- ALERT ERROR EDIT --}}
@if($errors->any() && old('form') == 'edit')
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    Periksa kembali data edit.
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>

<script>
    const id = "editModal" + "{{ old('edit_id') }}";
    new bootstrap.Modal(document.getElementById(id)).show();
</script>
@endif

<style>
    .btn-primary {
        background-color: #3f80ff;
        border-radius: 20px;
        padding: 8px 25px;
        border: none;
    }
    .table th {
        background: #f5f5f5;
        font-weight: 600;
        padding: 14px;
    }
    .table td {
        padding: 14px;
        vertical-align: middle;
        font-size: 15px;
    }
    .btn-edit {
        background: #e69a00;
        color: white;
        padding: 6px 20px;
        border-radius: 12px;
        border: none;
    }
    .btn-delete {
        background: #e74c3c;
        color: white;
        padding: 6px 20px;
        border-radius: 12px;
        border: none;
    }
</style>

<div class="card p-4 shadow-sm">

    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addModal">
        Tambah Kontak
    </button>

    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead>
                <tr>
                    <th style="width: 50px;">#</th>
                    <th>Nama</th>
                    <th>No HP</th>
                    <th style="width: 280px;">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($contacts as $i => $c)
                <tr>
                    <td>{{ $i+1 }}</td>
                    <td>{{ $c->nama }}</td>
                    <td>{{ $c->no_hp }}</td>
                    <td>
                        <button class="btn-edit"
                            data-bs-toggle="modal"
                            data-bs-target="#editModal{{ $c->id_contact }}">
                            Edit
                        </button>

                        <form action="{{ route('kontak.destroy', $c->id_contact) }}"
                              method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn-delete"
                                    onclick="return confirm('Hapus kontak ini?')">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>

                @empty
                <tr>
                    <td colspan="4" class="text-center text-muted py-4">
                        Tidak ada data.
                    </td>
                </tr>
                @endforelse
            </tbody>

        </table>
    </div>
</div>

{{-- ======================= MODAL ADD ======================= --}}
<div class="modal fade" id="addModal">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('kontak.store') }}" class="modal-content">
            @csrf
            <input type="hidden" name="form" value="add">

            <div class="modal-header">
                <h5 class="modal-title">Tambah Kontak</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <label>Nama</label>
                <input type="text" name="nama" value="{{ old('nama') }}" class="form-control mb-2" required>

                <label>No HP</label>
                <input type="text" name="no_hp" value="{{ old('no_hp') }}" class="form-control mb-2" required>
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

{{-- ======================= MODAL EDIT ======================= --}}
@foreach ($contacts as $c)
<div class="modal fade" id="editModal{{ $c->id_contact }}">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('kontak.update', $c->id_contact) }}" class="modal-content">
            @csrf
            @method('PUT')

            <input type="hidden" name="form" value="edit">
            <input type="hidden" name="edit_id" value="{{ $c->id_contact }}">

            <div class="modal-header">
                <h5 class="modal-title">Edit Kontak</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <label>Nama</label>
                <input type="text" name="nama"
                       value="{{ old('nama', $c->nama) }}"
                       class="form-control mb-2" required>

                <label>No HP</label>
                <input type="text" name="no_hp"
                       value="{{ old('no_hp', $c->no_hp) }}"
                       class="form-control mb-2" required>
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
