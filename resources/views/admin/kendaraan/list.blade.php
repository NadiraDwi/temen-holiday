@extends('admin.layouts')

@section('title', 'List Kendaraan')

<meta name="csrf-token" content="{{ csrf_token() }}">

@section('content')

@push('custom-css')
    <link href="https://cdn.datatables.net/v/bs5/dt-1.13.4/datatables.min.css" rel="stylesheet"/>
@endpush

<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Kendaraan</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">List</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- ========================== -->
<!-- BUTTON TAMBAH KENDARAAN -->
<!-- ========================== -->
<div class="d-flex justify-content-between mb-3">
    <div class="page-header-title">
      <h2 class="mb-0">List Kendaraan</h2>
  </div>
    <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#createModal">
        + Tambah Kendaraan
    </button>
</div>

<!-- Main Content -->
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive dt-responsive">
                    <table id="kendaraan-table" class="table table-striped table-bordered nowrap">
                        <thead>
                            <tr>
                                <th class="text-center" width="60px">#</th>
                                <th class="text-center">Nama Kendaraan</th>
                                <th class="text-center">Kategori</th>
                                <th class="text-center">Kapasitas</th>
                                <th>Fasilitas</th>
                                <th>Harga</th>
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
<!-- MODAL DETAIL                 -->
<!-- ============================ -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Detail Kendaraan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="row">
                    <!-- Gambar -->
                    <div class="col-md-5 text-center mb-3">
                        <img id="detail-gambar" src="" class="img-fluid rounded border" alt="Gambar Kendaraan">
                    </div>

                    <!-- Detail -->
                    <div class="col-md-7">
                        <table class="table table-sm">
                            <tr>
                                <th width="150px">Nama Kendaraan</th>
                                <td id="detail-nama"></td>
                            </tr>
                            <tr>
                                <th>Kapasitas</th>
                                <td id="detail-kapasitas"></td>
                            </tr>
                            <tr>
                                <th>Fasilitas</th>
                                <td id="detail-fasilitas"></td>
                            </tr>
                            <tr>
                                <th>Kontak</th>
                                <td id="detail-contact"></td>
                            </tr>
                            <tr>
                                <th>Harga</th>
                                <td id="detail-harga"></td>
                            </tr>
                             <tr>
                                <th>Tampilkan Harga</th>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" id="toggle-harga">
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <!-- FOOTER UNTUK EDIT & DELETE -->
            <div class="modal-footer">
                <button id="btn-edit" class="btn btn-outline-warning">
                    <i class="fas fa-edit"></i> Edit
                </button>

                <button id="btn-delete" class="btn btn-outline-danger">
                    <i class="fas fa-trash"></i> Hapus
                </button>
            </div>

        </div>
    </div>
</div>

<!-- ============================ -->
<!-- MODAL CREATE KENDARAAN      -->
<!-- ============================ -->
<div class="modal fade" id="createModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form id="form-create" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Tambah Kendaraan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <!-- Upload Gambar -->
                    <div class="mb-3 text-center">
                        <label class="form-label fw-bold">Gambar Kendaraan</label>

                        <div id="upload-area" class="upload-box">
                            <div class="upload-placeholder">
                                <i class="fas fa-cloud-upload-alt fa-2x mb-2 text-primary"></i>
                                <p>Browse Files to upload</p>
                            </div>

                            <img id="preview-image" class="preview-img d-none" alt="Preview">
                        </div>

                        <input type="file" name="gambar" id="gambar-input" class="d-none" accept="image/*">

                        <div class="d-flex justify-content-between mt-2">
                            <span id="file-name" class="small text-muted">No selected file</span>
                            <button type="button" id="btn-remove" class="btn btn-sm btn-outline-danger d-none">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Kategori -->
                    <div class="mb-3">
                        <label class="form-label">Kategori</label>
                        <select name="id_kategori" class="form-select" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach ($kategori as $k)
                                <option value="{{ $k->id_category }}">{{ $k->kategori }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Nama Kendaraan -->
                    <div class="mb-3">
                        <label class="form-label">Nama Kendaraan</label>
                        <input type="text" name="nama_kendaraan" class="form-control" required>
                    </div>

                    <!-- Kapasitas & Harga -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Kapasitas (orang)</label>
                            <input type="number" name="kapasitas" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Harga (Rp)</label>
                            <input type="number" name="harga" class="form-control" required>
                        </div>
                    </div>

                    <!-- Fasilitas -->
                    <div class="mb-3">
                        <label class="form-label">Fasilitas</label>
                        <textarea name="fasilitas" rows="3" class="form-control"></textarea>
                    </div>

                    <!-- Contact -->
                    <div class="mb-3">
                        <label class="form-label">Kontak</label>
                        <select name="id_contact" class="form-select" required>
                            <option value="">-- Pilih Kontak --</option>
                            @foreach ($contact as $c)
                                <option value="{{ $c->id_contact }}">{{ $c->nama }} ({{ $c->no_hp }})</option>
                            @endforeach
                        </select>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>

            </div>
        </form>
    </div>
</div>

<!-- ============================ -->
<!-- MODAL EDIT KENDARAAN        -->
<!-- ============================ -->
<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form id="form-edit" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" id="edit-id">
            <input type="hidden" name="hapus_gambar" id="hapus_gambar" value="0">

            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Edit Kendaraan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <!-- Upload Gambar -->
                    <div class="mb-3 text-center">
                        <label class="form-label fw-bold">Gambar Kendaraan</label>

                        <div id="edit-upload-area" class="upload-box">
                            <div class="upload-placeholder">
                                <i class="fas fa-cloud-upload-alt fa-2x mb-2 text-primary"></i>
                                <p>Browse Files to upload</p>
                            </div>

                            <img id="edit-preview-image" class="preview-img d-none" alt="Preview">
                        </div>

                        <input type="file" name="gambar" id="edit-gambar-input" class="d-none" accept="image/*">

                        <div class="d-flex justify-content-between mt-2">
                            <span id="edit-file-name" class="small text-muted">No selected file</span>
                            <button type="button" id="edit-btn-remove" class="btn btn-sm btn-outline-danger d-none">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Kategori -->
                    <div class="mb-3">
                        <label class="form-label">Kategori</label>
                        <select name="id_kategori" id="edit-kategori" class="form-select" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach ($kategori as $k)
                                <option value="{{ $k->id_category }}">{{ $k->kategori }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Nama Kendaraan -->
                    <div class="mb-3">
                        <label class="form-label">Nama Kendaraan</label>
                        <input type="text" id="edit-nama" name="nama_kendaraan" class="form-control" required>
                    </div>

                    <!-- Kapasitas & Harga -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Kapasitas (orang)</label>
                            <input type="number" id="edit-kapasitas" name="kapasitas" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Harga (Rp)</label>
                            <input type="number" id="edit-harga" name="harga" class="form-control" required>
                        </div>
                    </div>

                    <!-- Fasilitas -->
                    <div class="mb-3">
                        <label class="form-label">Fasilitas</label>
                        <textarea id="edit-fasilitas" name="fasilitas" rows="3" class="form-control"></textarea>
                    </div>

                    <!-- Contact -->
                    <div class="mb-3">
                        <label class="form-label">Kontak</label>
                        <select name="id_contact" id="edit-contact" class="form-select" required>
                            <option value="">-- Pilih Kontak --</option>
                            @foreach ($contact as $c)
                                <option value="{{ $c->id_contact }}">{{ $c->nama }} ({{ $c->no_hp }})</option>
                            @endforeach
                        </select>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning">Update</button>
                </div>

            </div>
        </form>
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
// =========================
// GLOBAL VARIABLE
// =========================
var selectedID = null;

// =========================
// DATATABLE
// =========================
$('#kendaraan-table').DataTable({
    processing: true,
    serverSide: true,
    responsive: true,
    order: [[1, 'asc']],
    ajax: "{{ route('admin.kendaraan.list') }}",
    language: {
        emptyTable: "Belum ada Data",
        processing: "Memuat data...",
        search: "Cari:",
    },
    columns: [
        { data: 'DT_RowIndex', className: "dt-body-center", orderable: false, searchable: false },
        { data: 'nama_kendaraan' },
        { data: 'kategori' },
        { data: 'kapasitas', className: "dt-body-center" },
        { data: 'fasilitas' },
        { data: 'harga' },
        { data: 'action', orderable: false, searchable: false, className: "dt-body-center" }
    ]
});

// =========================
// DELETE DATA
// =========================
document.getElementById("btn-delete").addEventListener("click", function () {
    const swalButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-outline-danger',
            cancelButton: 'btn btn-primary',
        },
        buttonsStyling: false
    });

    swalButtons.fire({
        title: 'Hapus kendaraan ini?',
        text: "Data akan dihapus permanen!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            axios.delete(`{{ route('admin.kendaraan.delete') }}`, {
                params: { id: selectedID }
            }).then(() => {
                swalButtons.fire('Dihapus!', 'Data kendaraan berhasil dihapus.', 'success')
                    .then(() => location.reload());
            });
        }
    });
});

// =============================
// DETAIL DATA
// =============================
$(document).on('click', '.btn-detail', function () {
    let id = $(this).data('id');
    detailData(id);
});

function detailData(id) {

    $.get('/admin/kendaraan/detail/' + id, function(res) {

        selectedID = id;

        // Set data
        $('#detail-nama').text(res.nama_kendaraan);
        $('#detail-kapasitas').text(res.kapasitas + ' Orang');
        $('#detail-fasilitas').html(res.fasilitas);
        $('#detail-contact').text(res.contact?.nama ?? '-');

        // Harga
        $('#detail-harga').text(
            'Rp ' + new Intl.NumberFormat('id-ID').format(res.harga)
        );

        // Gambar
        $('#detail-gambar').attr('src',
            res.gambar ? '/storage/kendaraan/' + res.gambar : '/no-image.png'
        );

        // ✅ Set toggle & label
        $('#toggle-harga').prop('checked', res.tampilkan_harga == 1);
        $('#label-harga').text(
            res.tampilkan_harga == 1 ? 'Sembunyikan' : 'Tampilkan'
        );

        // Tampilkan modal
        $('#detailModal').modal('show');
    });
}


// =============================
// CSRF SETUP (WAJIB ADA)
// =============================
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});


// =============================
// UPDATE TAMPILKAN HARGA
// =============================
$(document).on('change', '#toggle-harga', function () {
    if (!selectedID) return;

    let value = $(this).is(':checked') ? 1 : 0;

    $.ajax({
        url: '/admin/kendaraan/update-tampilkan-harga',
        type: 'POST',
        data: {
            id: selectedID,
            tampilkan_harga: value,
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function () {

            // ✅ Update label langsung
            $('#label-harga').text(
                value == 1 ? 'Sembunyikan' : 'Tampilkan'
            );

            toastr.success('Status tampilkan harga diperbarui!');

            // ✅ Reload datatable jika ada tabel
            if ($('#tabel-data').length) {
                $('#tabel-data').DataTable().ajax.reload(null, false);
            }
        },
        error: function () {
            toastr.error('Gagal memperbarui status');
        }
    });
});

// =========================
// EDIT DATA
// =========================
document.getElementById("btn-edit").addEventListener("click", function () {

    // Tutup modal detail
    const detailModal = bootstrap.Modal.getInstance(document.getElementById('detailModal'));
    if (detailModal) detailModal.hide();

    axios.get(`/admin/kendaraan/detail/${selectedID}`)
        .then(res => {
            const d = res.data;

            document.getElementById("edit-id").value = selectedID;

            resetEditImage();

            document.getElementById("edit-nama").value = d.nama_kendaraan;
            document.getElementById("edit-kapasitas").value = d.kapasitas;
            document.getElementById("edit-harga").value = d.harga;
            document.getElementById("edit-fasilitas").value = d.fasilitas;
            document.getElementById("edit-kategori").value = d.id_kategori;
            document.getElementById("edit-contact").value = d.id_contact;

            if (d.gambar) {
                showEditImage(`/storage/kendaraan/${d.gambar}`, d.gambar);
                document.getElementById("hapus_gambar").value = 0;
            }

            new bootstrap.Modal(document.getElementById('editModal')).show();
        });
});

// Submit Update
$('#form-edit').on('submit', function(e) {
    e.preventDefault();

    let formData = new FormData(this);
    formData.append('_method', 'PUT');

    axios.post(`/admin/kendaraan/update/${selectedID}`, formData)
        .then(() => {
            Swal.fire("Berhasil", "Kendaraan berhasil diperbarui!", "success")
                .then(() => location.reload());
        })
        .catch(() => Swal.fire("Gagal", "Periksa kembali input Anda!", "error"));
});

// =========================
// EDIT IMAGE HANDLER
// =========================
const editUploadArea = document.getElementById('edit-upload-area');
const editFileInput  = document.getElementById('edit-gambar-input');
const editPreview    = document.getElementById('edit-preview-image');
const editFileName   = document.getElementById('edit-file-name');
const editRemoveBtn  = document.getElementById('edit-btn-remove');
const editPlaceholder = document.querySelector('#edit-upload-area .upload-placeholder');
const hapusInput     = document.getElementById('hapus_gambar');

function resetEditImage() {
    editFileInput.value = '';
    editPreview.classList.add('d-none');
    editPreview.src = '';
    editPlaceholder.classList.remove('d-none');
    editFileName.textContent = 'No selected file';
    editRemoveBtn.classList.add('d-none');
    hapusInput.value = 0;
}

function showEditImage(url, name) {
    editPreview.src = url;
    editPreview.classList.remove('d-none');
    editPlaceholder.classList.add('d-none');
    editFileName.textContent = name;
    editRemoveBtn.classList.remove('d-none');
}

editUploadArea.addEventListener('click', () => editFileInput.click());

editFileInput.addEventListener('change', function () {
    const file = this.files[0];
    if (file) {
        const url = URL.createObjectURL(file);
        showEditImage(url, file.name);
        hapusInput.value = 0;
    }
});

editRemoveBtn.addEventListener('click', function () {
    resetEditImage();
    hapusInput.value = 1;
});

// =========================
// CREATE DATA
// =========================
$('#form-create').on('submit', function(e) {
    e.preventDefault();

    let formData = new FormData(this);

    axios.post("{{ route('admin.kendaraan.store') }}", formData)
        .then(() => {
            Swal.fire("Berhasil", "Kendaraan berhasil ditambahkan!", "success")
                .then(() => location.reload());
        })
        .catch(() => Swal.fire("Gagal", "Periksa kembali input Anda!", "error"));
});

// =========================
// CREATE IMAGE HANDLER
// =========================
const uploadArea   = document.getElementById('upload-area');
const fileInput    = document.getElementById('gambar-input');
const previewImg   = document.getElementById('preview-image');
const fileName     = document.getElementById('file-name');
const removeBtn    = document.getElementById('btn-remove');
const placeholder  = uploadArea.querySelector('.upload-placeholder');

uploadArea.addEventListener('click', () => fileInput.click());

fileInput.addEventListener('change', function () {
    const file = this.files[0];
    if (file) {
        const url = URL.createObjectURL(file);
        previewImg.src = url;
        previewImg.classList.remove('d-none');
        placeholder.classList.add('d-none');
        fileName.textContent = file.name;
        removeBtn.classList.remove('d-none');
    }
});

removeBtn.addEventListener('click', function () {
    fileInput.value = '';
    previewImg.src = '';
    previewImg.classList.add('d-none');
    placeholder.classList.remove('d-none');
    fileName.textContent = "No selected file";
    removeBtn.classList.add('d-none');
});

</script>
@endpush
