@extends('admin.layouts')

@section('title', 'Tambah Kendaraan')
<meta name="csrf-token" content="{{ csrf_token() }}">

@section('content')

@push('custom-css')
<style>
    .upload-box {
        border: 2px dashed #0d6efd;
        padding: 30px;
        text-align: center;
        border-radius: 10px;
        cursor: pointer;
    }
    .img-preview-wrap {
        position: relative;
        display: inline-block;
        margin: 8px;
    }
    .img-preview {
        width: 120px;
        height: 120px;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid #ddd;
    }
    .btn-remove-img {
        position: absolute;
        top: -6px;
        right: -6px;
        padding: 2px 6px;
    }
</style>
@endpush


<div class="card shadow-sm">
    <div class="card-header">
        <h5 class="mb-0">Tambah Kendaraan</h5>
    </div>

    <form id="form-create" enctype="multipart/form-data">
        @csrf
        <div class="card-body">

            <!-- Upload Multi Image -->
            <div class="mb-3">
                <label class="form-label fw-bold">Foto Kendaraan</label>

                <div id="upload-area" class="upload-box">
                    <i class="fas fa-cloud-upload-alt fa-2x text-primary"></i>
                    <p class="mt-2">Klik atau Drop foto untuk upload</p>
                </div>

                <input type="file"
                       name="images[]"
                       id="gambar-input"
                       class="d-none"
                       accept="image/*"
                       multiple>

                <div id="preview-container" class="mt-3 d-flex flex-wrap"></div>
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

            <!-- Nama -->
            <div class="mb-3">
                <label class="form-label">Nama Kendaraan</label>
                <input type="text" name="nama_kendaraan" class="form-control" required>
            </div>

            <!-- Kapasitas - Harga -->
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Kapasitas (Orang)</label>
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
                <textarea name="fasilitas" class="form-control" rows="3" required></textarea>
            </div>

            <!-- Kontak -->
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

        <div class="card-footer text-end">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Simpan
            </button>
        </div>
    </form>

</div>


@endsection


@push('custom-js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>
let selectedFiles = [];

// Klik area upload
document.getElementById('upload-area').addEventListener('click', () => {
    document.getElementById('gambar-input').click();
});

// Pilih via input
document.getElementById('gambar-input').addEventListener('change', function(e) {
    handleFiles(e.target.files);
});

// Drag & drop
const uploadArea = document.getElementById('upload-area');

uploadArea.addEventListener('dragover', e => {
    e.preventDefault();
    uploadArea.classList.add("bg-light");
});
uploadArea.addEventListener('dragleave', e => {
    e.preventDefault();
    uploadArea.classList.remove("bg-light");
});
uploadArea.addEventListener('drop', e => {
    e.preventDefault();
    uploadArea.classList.remove("bg-light");
    handleFiles(e.dataTransfer.files);
});

// ==== PREVIEW ====
function handleFiles(fileList) {
    [...fileList].forEach(file => {
        selectedFiles.push(file);
        previewImage(file);
    });
    syncInputFiles();
}

function previewImage(file) {
    const reader = new FileReader();
    reader.onload = e => {

        const wrap = document.createElement("div");
        wrap.className = "img-preview-wrap";

        wrap.innerHTML = `
            <img src="${e.target.result}" class="img-preview">
            <button type="button" class="btn btn-danger btn-sm btn-remove-img">
                <i class="fas fa-times"></i>
            </button>
        `;

        wrap.querySelector(".btn-remove-img").addEventListener("click", () => {
            const i = selectedFiles.indexOf(file);
            if (i > -1) selectedFiles.splice(i, 1);
            wrap.remove();
            syncInputFiles();
        });

        document.getElementById('preview-container').appendChild(wrap);
    };

    reader.readAsDataURL(file);
}

function syncInputFiles() {
    const dt = new DataTransfer();
    selectedFiles.forEach(f => dt.items.add(f));
    document.getElementById('gambar-input').files = dt.files;
}

// ==== SUBMIT ====
document.getElementById('form-create').addEventListener('submit', async function(e) {
    e.preventDefault();

    let formData = new FormData(this);

    // HAPUS file dari input default agar tidak double
    formData.delete("images[]");

    // Tambahkan file dari selectedFiles (hasil drag/drop + button remove)
    selectedFiles.forEach(f => formData.append("images[]", f));

    try {
        await axios.post("{{ route('admin.kendaraan.store') }}", formData);

        Swal.fire({
            icon: "success",
            title: "Berhasil",
            text: "Kendaraan berhasil ditambahkan!"
        }).then(() => {
            window.location.href = "{{ route('admin.kendaraan.index') }}";
        });

    } catch (err) {
        Swal.fire({
            icon: "error",
            title: "Gagal",
            text: "Terjadi kesalahan, cek kembali input."
        });
    }
});

</script>
@endpush

