@extends('admin.layouts')

@section('title', 'Tambah Wisata')
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
        <h5 class="mb-0">Tambah Wisata</h5>
    </div>

    <form id="form-create" enctype="multipart/form-data">
        @csrf
        <div class="card-body">

            {{-- Upload Multi Image --}}
            <div class="mb-3">
                <label class="form-label fw-bold">Foto Wisata</label>

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

            {{-- Nama --}}
            <div class="mb-3">
                <label class="form-label">Nama / Judul Wisata</label>
                <input type="text" name="title" class="form-control" placeholder="Contoh: Bromo Sunrise">
            </div>

            {{-- Deskripsi --}}
            <div class="mb-3">
                <label class="form-label">Deskripsi</label>
                <textarea name="description" class="form-control" rows="3"></textarea>
            </div>

            {{-- Include --}}
            <div class="mb-3">
                <label class="form-label">Include (Fasilitas / Paket)</label>
                <textarea name="include" class="form-control" rows="3" placeholder="Contoh: Transport, snack, dll..."></textarea>
            </div>

            {{-- Harga --}}
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Harga (Rp)</label>
                    <input type="number" name="price" class="form-control">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Label Harga</label>
                    <input type="text" name="price_label" class="form-control" placeholder="/orang">
                </div>
            </div>

            {{-- Kontak --}}
            <div class="mb-3">
                <label class="form-label">Kontak</label>
                <select name="contact_id" class="form-select">
                    <option value="">-- Pilih Kontak --</option>
                    @foreach ($contact as $c)
                        <option value="{{ $c->id_contact }}">
                            {{ $c->nama }} ({{ $c->no_hp }})
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Maps URL --}}
            <div class="mb-3">
                <label class="form-label">Google Maps URL</label>
                <input type="url" name="map_url" class="form-control" placeholder="https://maps.google.com/...">
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
axios.defaults.headers.common['X-CSRF-TOKEN'] =
    document.querySelector('meta[name="csrf-token"]').getAttribute('content');
</script>

<script>
let selectedFiles = [];

// Klik area upload
document.getElementById('upload-area').addEventListener('click', () => {
    document.getElementById('gambar-input').click();
});

// Input file
document.getElementById('gambar-input').addEventListener('change', function (e) {
    handleFiles(e.target.files);
});

// Drag-drop
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

// ===============================
// PREVIEW IMAGE
// ===============================
function handleFiles(fileList) {
    [...fileList].forEach(file => {

        // Hanya gambar yang diterima
        if (!file.type.startsWith("image/")) return;

        // Antisipasi duplikasi
        if (selectedFiles.includes(file)) return;

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

        wrap.querySelector(".btn-remove-img").onclick = () => {
            selectedFiles = selectedFiles.filter(f => f !== file);
            wrap.remove();
            syncInputFiles();
        };

        document.getElementById('preview-container').appendChild(wrap);
    };

    reader.readAsDataURL(file);
}

function syncInputFiles() {
    const dt = new DataTransfer();
    selectedFiles.forEach(f => dt.items.add(f));
    document.getElementById('gambar-input').files = dt.files;
}

// ===============================
// SUBMIT
// ===============================
document.getElementById('form-create').addEventListener('submit', async function (e) {
    e.preventDefault();

    let formData = new FormData(this);

    // Pastikan images[] memakai selectedFiles
    formData.delete("images[]");
    selectedFiles.forEach(f => formData.append("images[]", f));

    try {
        await axios.post("{{ route('wisata.store') }}", formData, {
            headers: { "Content-Type": "multipart/form-data" }
        });

        Swal.fire({
            icon: "success",
            title: "Berhasil",
            text: "Wisata berhasil ditambahkan!"
        }).then(() => window.location.href = "{{ route('wisata.index') }}");

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
