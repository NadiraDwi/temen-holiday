@extends('admin.layouts')

@section('title', 'List Kendaraan')

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
    <a href="{{ route('admin.kendaraan.create') }}" class="btn btn-outline-primary">
        + Tambah Kendaraan
    </a>
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
                                <th>Harga</th>
                                <td id="detail-harga"></td>
                            </tr>
                            <tr>
                                <th>Kontak</th>
                                <td id="detail-contact"></td>
                            </tr>
                            <tr>
                                <th>Diupdate Oleh</th>
                                <td id="detail-updatedby"></td>
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

@endsection


@push('custom-js')
<script src="{{ asset('assets') }}/js/jquery-3.7.0.min.js"></script>
<script src="{{ asset('assets') }}/js/plugins/jquery.dataTables.min.js"></script>
<script src="{{ asset('assets') }}/js/plugins/dataTables.bootstrap5.min.js"></script>
<script src="{{ asset('assets') }}/js/plugins/sweetalert2.all.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>
let selectedID = null; // GLOBAL VARIABLE
</script>

<script>
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
        { data: 'nama_kendaraan', name: 'nama_kendaraan' },
        { data: 'kapasitas', name: 'kapasitas', className: "dt-body-center" },
        { data: 'fasilitas', name: 'fasilitas' },
        { data: 'harga', name: 'harga' },
        { data: 'action', name: 'action', orderable: false, searchable: false, className: "dt-body-center" }
    ]

});
</script>

<script>
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
</script>

<script>
function detailData(id) {

    axios.get(`/admin/kendaraan/detail/${id}`)
        .then(res => {

            selectedID = id;

            const d = res.data;

            document.getElementById("detail-gambar").src =
                d.gambar ? `/storage/kendaraan/${d.gambar}` : `/assets/image/no-image.png`;

            document.getElementById("detail-nama").innerHTML = d.nama_kendaraan;
            document.getElementById("detail-kapasitas").innerHTML = d.kapasitas + " orang";
            document.getElementById("detail-fasilitas").innerHTML = d.fasilitas;
            document.getElementById("detail-harga").innerHTML = "Rp " + new Intl.NumberFormat('id-ID').format(d.harga);

            document.getElementById("detail-contact").innerHTML =
                d.contact ? d.contact.nama + " (" + d.contact.no_hp + ")" : "-";

            document.getElementById("detail-updatedby").innerHTML =
                d.updated_by_user ? d.updated_by_user.name : "-";

            new bootstrap.Modal(document.getElementById('detailModal')).show();
        })
        .catch(() => Swal.fire("Gagal", "Data kendaraan tidak ditemukan!", "error"));
}
</script>

<script>
document.getElementById("btn-edit").addEventListener("click", function () {
    window.location.href = `/admin/kendaraan/edit/${selectedID}`;
});
</script>

@endpush
