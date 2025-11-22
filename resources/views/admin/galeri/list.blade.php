@extends('admin.layouts')

@section('title', 'List Galeri')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between mb-3">
        <h4>Data Galeri</h4>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCreate">Tambah Galeri</button>
    </div>

    {{-- ✅ Tempat card dimuat --}}
    <div class="row" id="cardContainer"></div>

</div>


{{-- ========================= MODAL CREATE ========================= --}}
<div class="modal fade" id="modalCreate" tabindex="-1">
    <div class="modal-dialog">
        <form id="formCreate" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Galeri</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">

                    <div class="mb-3">
                        <label class="form-label">Judul</label>
                        <input type="text" name="judul" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Gambar</label>
                        <input type="file" name="gambar" id="create_gambar" class="form-control" required>
                    </div>

                    <div class="mb-3 text-center d-none" id="preview_wrap">
                        <img id="preview_create" src="" width="150" class="rounded border">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>


{{-- ========================= MODAL EDIT ========================= --}}
<div class="modal fade" id="modalEdit" tabindex="-1">
    <div class="modal-dialog">
        <form id="formEdit" enctype="multipart/form-data">
            @csrf
            <input type="hidden" id="edit_id">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Galeri</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">

                    <div class="mb-3">
                        <label class="form-label">Judul</label>
                        <input type="text" id="edit_judul" name="judul" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Gambar (opsional)</label>
                        <input type="file" name="gambar" id="edit_gambar" class="form-control">
                    </div>

                    <div class="mb-3 text-center">
                        <img id="preview_gambar" src="" width="150" class="rounded border">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning">Update</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection


@push('custom-js')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

// ✅ TEMPLATE CARD — pakai id_galeri
function cardTemplate(item) {
    return `
        <div class="col-md-3 mb-3" id="card-${item.id_galeri}">
            <div class="card shadow-sm">
                <img src="/storage/galeri/${item.gambar}" class="card-img-top" height="180" style="object-fit:cover">
                <div class="card-body text-center">
                    <h6>${item.judul}</h6>
                    <button class="btn btn-sm btn-warning" onclick="editData('${item.id_galeri}')">Edit</button>
                    <button class="btn btn-sm btn-danger" onclick="deleteData('${item.id_galeri}')">Hapus</button>
                </div>
            </div>
        </div>
    `;
}


// ✅ LOAD DATA
function loadGaleri() {
    $.get("{{ route('galeri.list') }}", function(res){
        $('#cardContainer').html('');
        res.data.forEach(item => {
            $('#cardContainer').append(cardTemplate(item));
        });
    });
}

loadGaleri();


// ✅ STORE
$('#formCreate').submit(function(e){
    e.preventDefault();
    let formData = new FormData(this);

    $.ajax({
        url: "{{ route('galeri.store') }}",
        method: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function(res){
            $('#modalCreate').modal('hide');
            $('#formCreate')[0].reset();
            $('#cardContainer').prepend(cardTemplate(res.data));
            Swal.fire("Berhasil", "Galeri ditambahkan!", "success");
        }
    });
});

// ✅ EDIT
function editData(id){
    $.ajax({
        url: `/admin/galeri/edit/${id}`,
        type: "GET",
        success: function(res){

            $('#edit_id').val(res.data.id_galeri);
            $('#edit_judul').val(res.data.judul);

            $('#preview_gambar')
                .attr('src', `/storage/galeri/${res.data.gambar}`)
                .show();

            $('#modalEdit').modal('show');
        }
    });
}

$('#formEdit').submit(function(e){
    e.preventDefault();
    let id = $('#edit_id').val();
    let formData = new FormData(this);

    $.ajax({
        url: `/admin/galeri/update/${id}`,
        method: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function(res){
            $('#modalEdit').modal('hide');

            $(`#card-${res.data.id_galeri}`).replaceWith(cardTemplate(res.data));

            Swal.fire("Berhasil", "Galeri diperbarui!", "success");
        }
    });
});

// ✅ DELETE
function deleteData(id){
    Swal.fire({
        title: "Hapus galeri?",
        text: "Data tidak bisa dikembalikan.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Hapus",
        cancelButtonText: "Batal",
    }).then((res) => {
        if (res.isConfirmed) {
            $.ajax({
                url: "{{ route('galeri.delete') }}",
                type: "DELETE",
                data: { id: id, _token: "{{ csrf_token() }}" },
                success: function () {
                    $(`#card-${id}`).remove();
                    Swal.fire("Berhasil", "Data dihapus", "success");
                }
            });
        }
    });
}

</script>

@endpush
