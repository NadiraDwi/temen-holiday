@extends('admin.layouts')

@section('title', 'List Open Trip')

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
                    <li class="breadcrumb-item"><a href="#">Open Trip</a></li>
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
      <h2 class="mb-0">List Open Trip</h2>
  </div>
    <a href="{{ route('trip.create') }}" class="btn btn-outline-primary">
        + Create Open Trip
    </a>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive dt-responsive">
                <table id="tbl-open-trip" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th class="text-center" width="60px">#</th>
                            <th>Nama Trip</th>
                            <th>Deskripsi</th>
                            <th>Harga</th>
                            <th width="100px">Action</th>
                        </tr>
                    </thead>
                </table>
            </div>

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
$(function () {
    $('#tbl-open-trip').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('trip.list') }}",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'title', name: 'title' },
            { 
                data: 'description',
                name: 'description',
                render: function (data) {
                    return data ? data.substring(0, 60) + '...' : '-';
                }
            },
            { 
                data: 'price',
                name: 'price',
                render: function (data) {
                    return 'Rp ' + new Intl.NumberFormat('id-ID').format(data);
                }
            },
            { 
                data: 'id',
                render: function(id) {
                    return `
                        <a href="trip/detail/${id}" class="btn btn-sm btn-primary">
                            Detail
                        </a>
                    `;
                }
            }
        ]
    });
});
</script>

@endpush