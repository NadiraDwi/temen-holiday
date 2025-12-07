@extends('admin.layouts')

@section('title', 'Edit Wisata')

<meta name="csrf-token" content="{{ csrf_token() }}">

@section('content')

@push('custom-css')
<style>
    .upload-box {
        border: 2px dashed #ff9900;
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
        <h5 class="mb-0">Edit Wisata</h5>
    </div>

    <form id="form-edit" enctype="multipart/form-data">
        @csrf

        <div class="card-body">

            {{-- =============================== --}}
            {{-- UPLOAD AREA (SAMA IMPORNYA DENGAN CREATE) --}}
            {{-- =============================== --}}
            <div class="mb-3">
                <label class="form-label fw-bold">Gambar Wisata</label>

                <div id="upload-area-edit" class="upload-box bg-light-warning">
                    <i class="fas fa-cloud-upload-alt fa-2x text-warning"></i>
                    <p class="mt-2">Klik atau Drop foto untuk upload</p>
                </div>

                <input type="file"
                       id="edit-images"
                       class="d-none"
                       accept="image/*"
                       multiple />

                <p class="fw-bold mt-3">Gambar Lama:</p>
                <div id="old-images" class="d-flex flex-wrap">
                    @foreach ($data->images as $img)
                        <div class="img-preview-wrap old-image" data-name="{{ $img }}">
                            <img src="{{ asset('storage/'.$img) }}" class="img-preview">
                            <button type="button"
                                class="btn btn-danger btn-sm btn-remove-img remove-old"
                                data-name="{{ $img }}">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    @endforeach
                </div>

                <p class="fw-bold mt-3">Preview Gambar Baru:</p>
                <div id="new-preview" class="d-flex flex-wrap"></div>

                <input type="hidden" id="hapus_images" name="hapus_images">
            </div>


            {{-- FORM LAINNYA --}}
            <div class="mb-3">
                <label class="form-label">Nama Wisata</label>
                <input type="text" name="title" class="form-control" value="{{ $data->title }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Deskripsi</label>
                <textarea name="description" class="form-control">{{ $data->description }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Harga (Rp)</label>
                <input type="number" name="price" class="form-control" value="{{ $data->price }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Label Harga</label>
                <input type="text" name="price_label" class="form-control" value="{{ $data->price_label }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Include</label>
                <textarea name="include" rows="3" class="form-control">{{ $data->include }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Maps URL</label>
                <input type="url" name="map_url" class="form-control" value="{{ $data->map_url }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Kontak</label>
                <select name="contact_id" class="form-select">
                    @foreach ($contact as $c)
                        <option value="{{ $c->id_contact }}" {{ $c->id_contact == $data->id_contact ? 'selected' : '' }}>
                            {{ $c->nama }} ({{ $c->no_hp }})
                        </option>
                    @endforeach
                </select>
            </div>

        </div>

        <div class="card-footer text-end">
            <button class="btn btn-warning">Update</button>
        </div>
    </form>

</div>

@endsection


@push('custom-js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
let hapusList   = [];
let newFiles    = [];
let previewArea = document.getElementById("new-preview");
let fileInput   = document.getElementById("edit-images");
let uploadBox   = document.getElementById("upload-area-edit");


// ===============================
// CLICK → OPEN INPUT
// ===============================
uploadBox.addEventListener("click", () => {
    fileInput.click();
});

// DRAG & DROP
uploadBox.addEventListener("dragover", e => {
    e.preventDefault();
    uploadBox.classList.add("bg-light");
});
uploadBox.addEventListener("dragleave", e => {
    e.preventDefault();
    uploadBox.classList.remove("bg-light");
});
uploadBox.addEventListener("drop", e => {
    e.preventDefault();
    uploadBox.classList.remove("bg-light");
    handleFiles(e.dataTransfer.files);
});


// ===============================
// HANDLE FILES (MIRIP CREATE)
// ===============================
fileInput.addEventListener("change", e => {
    handleFiles(e.target.files);
});

function handleFiles(files) {
    [...files].forEach(file => {
        if (!file.type.startsWith("image/")) return;

        newFiles.push(file);
        previewImage(file);
    });

    fileInput.value = "";
}

function previewImage(file) {
    let reader = new FileReader();
    reader.onload = e => {
        let box = document.createElement("div");
        box.className = "img-preview-wrap";
        box.setAttribute("data-new", file.name);

        box.innerHTML = `
            <img src="${e.target.result}" class="img-preview">
            <button type="button" class="btn btn-danger btn-sm btn-remove-img remove-new" data-name="${file.name}">
                <i class="fas fa-times"></i>
            </button>
        `;

        previewArea.appendChild(box);
    };
    reader.readAsDataURL(file);
}


// ===============================
// REMOVE OLD IMAGE
// ===============================
document.querySelectorAll(".remove-old").forEach(btn => {
    btn.onclick = function () {
        let name = this.dataset.name;
        hapusList.push(name);

        document.getElementById("hapus_images").value = JSON.stringify(hapusList);
        this.parentElement.remove();
    };
});


// ===============================
// REMOVE NEW IMAGE
// ===============================
document.addEventListener("click", function (e) {
    if (!e.target.closest(".remove-new")) return;

    let name = e.target.closest(".remove-new").dataset.name;
    newFiles = newFiles.filter(f => f.name !== name);

    document.querySelector(`[data-new="${name}"]`)?.remove();
});


// ===============================
// SUBMIT (TIDAK DIUBAH FUNGSINYA)
// ===============================
document.getElementById("form-edit").addEventListener("submit", function (e) {
    e.preventDefault();

    let formData = new FormData(this);
    newFiles.forEach(f => formData.append("images[]", f));

    fetch("{{ route('wisata.update', $data->id) }}", {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
            "Accept": "application/json",
            "X-Requested-With": "XMLHttpRequest"
        },
        body: formData
    })
    .then(res => res.json())
    .then(res => {
        if (res.success) {
            Swal.fire("Berhasil", "Data wisata berhasil diperbarui.", "success")
                .then(() => location.href = "{{ route('wisata.index') }}");
        } else {
            Swal.fire("Error", res.message ?? "Terjadi kesalahan.", "error");
        }
    })
    .catch(err => Swal.fire("Error", err.message, "error"));
});
</script>
@endpush
