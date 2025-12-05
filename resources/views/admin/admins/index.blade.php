@extends('admin.layouts')

@section('title', 'Kelola Admin')

@section('content')

<div class="page-header mb-3">
    <h4>Kelola Admin</h4>
</div>

{{-- ALERT SUCCESS --}}
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

{{-- ALERT GAGAL EDIT ROLE SUPERADMIN --}}
@if(session('edit_error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    {{ session('edit_error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

{{-- ALERT ERROR VALIDASI ADD --}}
@if($errors->any() && old('form') == 'add')
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    
    {{-- Kalau ada error email --}}
    @if($errors->has('email'))
        {{ $errors->first('email') }}
    
    {{-- Kalau ada error name --}}
    @elseif($errors->has('name'))
        {{ $errors->first('name') }}

    {{-- Kalau ada error password --}}
    @elseif($errors->has('password'))
        {{ $errors->first('password') }}

    {{-- Fallback --}}
    @else
        Periksa kembali data yang kamu masukkan.
    @endif

    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>

<script>
    new bootstrap.Modal(document.getElementById('addAdminModal')).show();
</script>
@endif

{{-- ALERT ERROR VALIDASI UPDATE --}}
@if($errors->any() && old('form') == 'edit')
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    Periksa kembali data edit yang kamu masukkan.
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<script>
    new bootstrap.Modal(document.getElementById('editAdminModal')).show();
</script>
@endif


<div class="card p-4 shadow-sm">

    {{-- BUTTON TAMBAH ADMIN --}}
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addAdminModal">
        Tambah Admin
    </button>

    {{-- TABLE --}}
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($admins as $index => $admin)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $admin->name }}</td>
                    <td>{{ $admin->email }}</td>
                    <td>
                        @if($admin->role == 'superadmin')
                            <span class="badge bg-danger">Super Admin</span>
                        @else
                            <span class="badge bg-primary">Admin</span>
                        @endif
                    </td>
                    <td>
                        <button class="btn btn-warning btn-sm"
                            onclick="openEditModal('{{ $admin->id }}', '{{ $admin->name }}', '{{ $admin->email }}', '{{ $admin->role }}')">
                            Edit
                        </button>

                        @if ($admin->role != 'superadmin')
                        <form action="{{ route('admin.destroy', $admin->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm"
                                onclick="return confirm('Yakin ingin menghapus admin ini?')">Hapus</button>
                        </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- MODAL ADD ADMIN --}}
<div class="modal fade" id="addAdminModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('admin.store') }}" method="POST" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Tambah Admin</h5>
            </div>

            <div class="modal-body">
                <input type="hidden" name="form" value="add">

                <label>Nama</label>
                <input type="text" name="name" class="form-control mb-2" value="{{ old('name') }}" required>

                <label>Email</label>
                <input type="email" name="email" class="form-control mb-2" value="{{ old('email') }}" required>

                <label>Password</label>
                <input type="password" name="password" class="form-control mb-2" required>

                <label>Role</label>
                <select name="role" class="form-control" required>
                    <option value="admin" @selected(old('role')=='admin')>Admin</option>
                    <option value="superadmin" @selected(old('role')=='superadmin')>Super Admin</option>
                </select>
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL EDIT --}}
<div class="modal fade" id="editAdminModal" tabindex="-1">
    <div class="modal-dialog">
        <form method="POST" class="modal-content" id="editAdminForm">
            @csrf
            @method('PUT')

            <div class="modal-header">
                <h5 class="modal-title">Edit Admin</h5>
            </div>

            <div class="modal-body">
                <input type="hidden" name="form" value="edit">

                <input type="hidden" name="id" id="edit_id">

                <label>Nama</label>
                <input type="text" name="name" id="edit_name" class="form-control mb-2" required>

                <label>Email</label>
                <input type="email" name="email" id="edit_email" class="form-control mb-2" required>

                <label>Password (opsional)</label>
                <input type="password" name="password" class="form-control mb-2">

                <label>Role</label>
                <select name="role" id="edit_role" class="form-control" required>
                    <option value="admin">Admin</option>
                    <option value="superadmin">Super Admin</option>
                </select>
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
    function openEditModal(id, name, email, role) {
        document.getElementById('edit_id').value = id;
        document.getElementById('edit_name').value = name;
        document.getElementById('edit_email').value = email;
        document.getElementById('edit_role').value = role;

        document.getElementById('editAdminForm').action = "/admin/admins/" + id;

        new bootstrap.Modal(document.getElementById('editAdminModal')).show();
    }
</script>
@endsection
