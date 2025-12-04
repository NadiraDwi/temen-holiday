@extends('admin.layouts')

@section('title', 'List Kendaraan')

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
                    <li class="breadcrumb-item"><a href="#">Kendaraan</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">List</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>


<div class="d-flex justify-content-between mb-3">
    <h2 class="mb-0">List Kendaraan</h2>

    <a href="{{ route('admin.kendaraan.create') }}" class="btn btn-outline-primary">
        + Tambah Kendaraan
    </a>
</div>


<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                
                <div class="table-responsive dt-responsive">
                    <table id="kendaraan-table" class="table table-striped table-bordered nowrap">
                        <thead>
                            <tr>
                                <th width="55px" class="text-center">#</th>
                                <th>Nama Kendaraan</th>
                                <th>Kategori</th>
                                <th class="text-center">Kapasitas</th>
                                <th>Fasilitas</th>
                                <th>Harga</th>
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
                <h5 class="modal-title">Detail Kendaraan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <div class="row">

                    {{-- CAROUSEL GALERI --}}
                    <div class="col-md-5 text-center mb-3">

                        <div id="carouselDetail" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner" id="carousel-images">
                                {{-- Dynamic slides injected by JS --}}
                            </div>

                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselDetail" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon"></span>
                            </button>

                            <button class="carousel-control-next" type="button" data-bs-target="#carouselDetail" data-bs-slide="next">
                                <span class="carousel-control-next-icon"></span>
                            </button>
                        </div>

                    </div>

                    {{-- DETAIL INFO --}}
                    <div class="col-md-7">
                        <table class="table table-sm">
                            <tr><th width="150px">Nama Kendaraan</th><td id="detail-nama"></td></tr>
                            <tr><th>Kapasitas</th><td id="detail-kapasitas"></td></tr>
                            <tr><th>Fasilitas</th><td id="detail-fasilitas"></td></tr>
                            <tr><th>Kontak</th><td id="detail-contact"></td></tr>
                            <tr><th>Harga</th><td id="detail-harga"></td></tr>

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
        { data: 'DT_RowIndex', orderable: false, searchable: false, className: "text-center" },
        { data: 'nama_kendaraan' },
        { data: 'kategori' },
        { data: 'kapasitas', className: "text-center" },
        { data: 'fasilitas' },
        { data: 'harga' },
        { data: 'action', orderable: false, searchable: false, className: "text-center" }
    ]
});



/* ============================
   DETAIL (WITH SLIDER)
============================ */
$(document).on('click', '.btn-detail', function () {
    detailData($(this).data('id'));
});

function detailData(id) {

    $.get(`/admin/kendaraan/detail/${id}`, function(res) {

        selectedID = id;

        $('#detail-nama').text(res.nama_kendaraan);
        $('#detail-kapasitas').text(res.kapasitas + ' Orang');
        $('#detail-fasilitas').html(res.fasilitas);
        $('#detail-contact').text(res.contact?.nama ?? '-');

        $('#detail-harga').text(
            res.harga ? 'Rp ' + new Intl.NumberFormat('id-ID').format(res.harga) : '-'
        );


        /* =====================================================
           BUILD CAROUSEL IMAGES
        ===================================================== */
        let carouselHTML = "";

        if (Array.isArray(res.images) && res.images.length > 0) {

            res.images.forEach((img, index) => {
                carouselHTML += `
                    <div class="carousel-item ${index === 0 ? 'active' : ''}">
                        <img src="${img}" 
                             class="d-block w-100 rounded border"
                             style="max-height:350px;object-fit:cover;">
                    </div>
                `;
            });

        } else {
            carouselHTML = `
                <div class="carousel-item active">
                    <img src="{{ asset('assets/images/no-image.png') }}"
                         class="d-block w-100 rounded border"
                         style="max-height:350px;object-fit:cover;">
                </div>
            `;
        }

        $("#carousel-images").html(carouselHTML);


        /* Toggle tampilkan harga */
        $('#toggle-harga').prop('checked', Number(res.tampilkan_harga) === 1);

        $('#detailModal').modal('show');

    }).fail(() => {
        Swal.fire("Error", "Gagal memuat detail kendaraan", "error");
    });
}



/* ============================
   CSRF Axios
============================ */
axios.defaults.headers.common['X-CSRF-TOKEN'] =
    document.querySelector('meta[name="csrf-token"]').content;



/* ============================
   TOGGLE TAMPIKAN HARGA
============================ */
$('#toggle-harga').on('change', function() {

    axios.post('/admin/kendaraan/update-tampilkan-harga', {
        id: selectedID,
        tampilkan_harga: $(this).is(':checked') ? 1 : 0
    }).then(() => {
        Swal.fire('Berhasil', 'Tampilkan harga diperbarui!', 'success');
        $('#kendaraan-table').DataTable().ajax.reload(null, false);
    }).catch(() => {
        Swal.fire('Error', 'Gagal update tampilkan harga', 'error');
    });
});



/* ============================
   EDIT BUTTON
============================ */
$('#btn-edit').on('click', function () {
    const modal = bootstrap.Modal.getInstance(document.getElementById('detailModal'));
    modal.hide();

    window.location.href = `/admin/kendaraan/edit/${selectedID}`;
});



/* ============================
   DELETE BUTTON
============================ */
$('#btn-delete').on('click', function () {

    if (!selectedID) {
        Swal.fire("Error", "ID tidak ditemukan", "error");
        return;
    }

    Swal.fire({
        title: 'Hapus Kendaraan?',
        text: "Data akan dihapus permanen!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {

            axios.delete(`/admin/kendaraan/delete/${selectedID}`)
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
