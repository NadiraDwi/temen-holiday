@extends('admin.layouts')

@section('title', 'Kategori Kendaraan')

@section('content')

@push('custom-css')
<link href="https://cdn.datatables.net/v/bs5/dt-1.13.4/datatables.min.css" rel="stylesheet"/>
@endpush


<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item">Kendaraan</li>
                    <li class="breadcrumb-item">Kategori</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="d-flex justify-content-between mb-3">
    <h2 class="mb-0">Kategori Kendaraan</h2>
    <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#createModal">
        + Tambah Kategori
    </button>
</div>

<!-- Main Content -->
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive dt-responsive">
                    <table id="kategori-table" class="table table-striped table-bordered nowrap">
                        <thead>
                            <tr>
                                <th class="text-center" width="60px">#</th>
                                <th class="">Kategori</th>
                                <th class="">Keterangan</th>
                                <th width="200px" class="text-center">Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- ============================ -->
<!-- MODAL TAMBAH KATEGORI        -->
<!-- ============================ -->
<div class="modal fade" id="createModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Tambah Kategori Kendaraan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form id="form-create">
                @csrf
                <div class="modal-body">

                    <div class="mb-3">
                        <label class="form-label">Nama Kategori <span class="text-danger">*</span></label>
                        <input type="text" name="kategori" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Keterangan</label>
                        <textarea name="keterangan" class="form-control" rows="3"></textarea>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>

        </div>
    </div>
</div>

<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Kategori</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="edit_id">

                <div class="mb-3">
                    <label>Kategori</label>
                    <input type="text" id="edit_kategori" class="form-control">
                </div>

                <div class="mb-3">
                    <label>Keterangan</label>
                    <textarea id="edit_keterangan" class="form-control"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button class="btn btn-primary" onclick="updateData()">Simpan</button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('custom-js')
<script src="{{ asset('assets') }}/js/jquery-3.7.0.min.js"></script>
<script src="{{ asset('assets') }}/js/plugins/jquery.dataTables.min.js"></script>
<script src="{{ asset('assets') }}/js/plugins/dataTables.bootstrap5.min.js"></script>
<script src="{{ asset('assets') }}/js/plugins/sweetalert2.all.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>
$('#kategori-table').DataTable({
    processing: true,
    serverSide: true,
    ajax: "{{ route('kategori-kendaraan.list') }}",
    columns: [
        { data: 'DT_RowIndex', orderable: false, searchable: false, className: "text-center" },
        { data: 'kategori' },
        { data: 'keterangan' },
        { data: 'action', orderable: false, searchable: false, className: "text-center" }
    ]
});
</script>

<script>
function deleteData(id) {
    Swal.fire({
        title: "Hapus kategori?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Hapus",
        cancelButtonText: "Batal",
    }).then((res) => {
        if (res.isConfirmed) {
            $.ajax({
                url: "{{ route('kategori-kendaraan.delete') }}",
                type: "DELETE",
                data: { id: id, _token: "{{ csrf_token() }}" },
                success: function () {
                    Swal.fire("Berhasil", "Data dihapus", "success");
                    $('#kategori-table').DataTable().ajax.reload();
                }
            });
        }
    });
}
</script>

<script>
$('#form-create').on('submit', function(e) {
    e.preventDefault();

    $.ajax({
        url: "{{ route('kategori-kendaraan.store') }}",
        type: "POST",
        data: $(this).serialize(),
        success: function() {
            Swal.fire("Berhasil", "Kategori berhasil ditambahkan", "success");

            $('#createModal').modal('hide');
            $('#form-create')[0].reset();

            $('#kategori-table').DataTable().ajax.reload();
        },
        error: function(xhr) {
            if (xhr.status === 422) {
                let errors = xhr.responseJSON.errors;
                let message = "";

                Object.keys(errors).forEach(key => {
                    message += errors[key][0] + "<br>";
                });

                Swal.fire({
                    icon: 'error',
                    title: 'Validasi Gagal',
                    html: message
                });
            } else {
                Swal.fire("Error", "Terjadi kesalahan server.", "error");
            }
        }
    });
});

// ======================= EDIT =========================

function editData(id) {
    $.ajax({
        url: "{{ route('kategori-kendaraan.show') }}",
        type: "GET",
        data: { id: id },
        success: function(res) {
            $('#edit_id').val(res.id_category);
            $('#edit_kategori').val(res.kategori);
            $('#edit_keterangan').val(res.keterangan);

            $('#editModal').modal('show');
        }
    });
}

// ======================= UPDATE =======================

function updateData() {
    $.ajax({
        url: "{{ route('kategori-kendaraan.update') }}",
        type: "PUT",
        data: {
            id: $('#edit_id').val(),
            kategori: $('#edit_kategori').val(),
            keterangan: $('#edit_keterangan').val(),
            _token: "{{ csrf_token() }}"
        },
        success: function() {
            $('#editModal').modal('hide');
            $('#kategori-table').DataTable().ajax.reload();
            Swal.fire("Berhasil", "Data berhasil diperbarui", "success");
        },
        error: function(xhr) {
            if (xhr.status === 422) {
                let errors = xhr.responseJSON.errors;
                let message = "";

                Object.keys(errors).forEach(key => {
                    message += errors[key][0] + "<br>";
                });

                Swal.fire({
                    icon: 'error',
                    title: 'Validasi Gagal',
                    html: message
                });
            } else {
                Swal.fire("Error", "Terjadi kesalahan server.", "error");
            }
        }
    });
}
</script>

@endpush
