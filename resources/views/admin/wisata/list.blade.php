@extends('admin.layouts')

@section('title', 'List Wisata')

@push('custom-css')
<link href="https://cdn.datatables.net/v/bs5/dt-1.13.4/datatables.min.css" rel="stylesheet"/>
@endpush

@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Wisata</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">List</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="d-flex justify-content-between mb-3">
    <h2 class="mb-0">List Wisata</h2>

    <a href="{{ route('wisata.create') }}" class="btn btn-outline-primary">
        + Tambah Wisata
    </a>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">

                <div class="table-responsive dt-responsive">
                    <table id="wisata-table" class="table table-striped table-bordered nowrap">
                        <thead>
                            <tr>
                                <th width="55px" class="text-center">#</th>
                                <th>Judul</th>
                                <th>Harga</th>
                                <th>Kontak</th>
                                <th width="150px" class="text-center">Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>


{{-- ==================================== --}}
{{-- MODAL DETAIL --}}
{{-- ==================================== --}}
<div class="modal fade" id="detailModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Detail Wisata</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <div class="row">

                    {{-- CAROUSEL --}}
                    <div class="col-md-5 mb-3">
                        <div id="carouselDetail" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner" id="carousel-images"></div>

                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselDetail" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon"></span>
                            </button>

                            <button class="carousel-control-next" type="button" data-bs-target="#carouselDetail" data-bs-slide="next">
                                <span class="carousel-control-next-icon"></span>
                            </button>
                        </div>
                    </div>

                    {{-- DETAIL --}}
                    <div class="col-md-7">
                        <table class="table table-sm">
                            <tr><th width="150px">Judul</th><td id="detail-title"></td></tr>
                            <tr><th>Harga</th><td id="detail-price"></td></tr>
                            <tr><th>Kontak</th><td id="detail-contact"></td></tr>
                            <tr><th>Include</th><td id="detail-include"></td></tr>
                            <tr><th>Deskripsi</th><td id="detail-description"></td></tr>
                            <tr><th>Maps</th><td><a href="#" target="_blank" id="detail-maps">Lihat Lokasi</a></td></tr>
                        </table>
                    </div>

                </div>

            </div>

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

<script src="{{ asset('assets/js/jquery-3.7.0.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/dataTables.bootstrap5.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/sweetalert2.all.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>
let selectedID = null;

/* ============================
   DATATABLE
============================ */
$('#wisata-table').DataTable({
    processing: true,
    serverSide: true,
    responsive: true,
    order: [[1, 'asc']],

    ajax: "{{ route('wisata.list') }}",

    language: { emptyTable: "Belum ada Data" },

    columns: [
        { data: 'DT_RowIndex', orderable: false, searchable: false, className:"text-center" },
        { data: 'title' },
        { data: 'price' },
        { data: 'contact.nama', defaultContent: '-' },
        { data: 'action', orderable: false, searchable: false, className:"text-center" }
    ]
});


/* ============================
   DETAIL
============================ */
$(document).on('click', '.btn-detail', function () {
    detailData($(this).data('id'));
});

function detailData(id) {

    $.get(`/admin/wisata/detail/${id}`, function(res) {

        selectedID = id;

        $('#detail-title').text(res.title ?? '-');
        $('#detail-price').text('Rp ' + new Intl.NumberFormat('id-ID').format(res.price ?? 0));
        $('#detail-contact').text(res.contact?.nama ?? '-');

        // include & description aman HTML
        $('#detail-include').html(res.include ?? '-');
        $('#detail-description').html(res.description ?? '-');

        $('#detail-maps').attr('href', res.map_url ?? "#");

        /* BUILD SLIDER */
        let html = "";

        if (Array.isArray(res.images) && res.images.length > 0) {
            res.images.forEach((img, i) => {
                html += `
                    <div class="carousel-item ${i===0?'active':''}">
                        <img src="${img}" class="d-block w-100 rounded border" style="max-height:350px;object-fit:cover;">
                    </div>
                `;
            });
        } else {
            html = `
                <div class="carousel-item active">
                    <img src="{{ asset('assets/images/no-image.png') }}"
                         class="d-block w-100 rounded border"
                         style="max-height:350px;object-fit:cover;">
                </div>
            `;
        }

        $('#carousel-images').html(html);

        $('#detailModal').modal('show');

    }).fail(() => Swal.fire("Error","Gagal memuat detail","error"));
}


/* ============================
   EDIT BUTTON
============================ */
$('#btn-edit').on('click', function () {
    const modal = bootstrap.Modal.getInstance(document.getElementById('detailModal'));
    modal.hide();

    window.location.href = `/admin/wisata/edit/${selectedID}`;
});


/* ============================
   DELETE BUTTON
============================ */
$('#btn-delete').on('click', function () {

    Swal.fire({
        title: 'Hapus Wisata?',
        text: 'Data akan dihapus permanen!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, Hapus!'
    }).then(result => {
        if (result.isConfirmed) {

            axios.delete(`/admin/wisata/delete/${selectedID}`)
            .then(() => {
                Swal.fire('Terhapus!', 'Data berhasil dihapus.', 'success')
                    .then(() => location.reload());
            })
            .catch(() => Swal.fire('Error', 'Gagal menghapus data', 'error'));

        }
    });

});
</script>

@endpush
