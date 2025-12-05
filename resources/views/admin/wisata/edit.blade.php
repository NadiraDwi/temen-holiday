@extends('admin.layouts')

@section('title', 'Edit Wisata')

<meta name="csrf-token" content="{{ csrf_token() }}">

@section('content')

<style>
    .preview-img {
        width: 140px;
        height: 100px;
        object-fit: cover;
        border: 1px solid #ccc;
        border-radius: 6px;
        margin-right: 10px;
    }
    .img-wrapper {
        position: relative;
        display: inline-block;
        margin-right: 8px;
        margin-bottom: 8px;
    }
    .btn-remove-image {
        position: absolute;
        top: -6px;
        right: -6px;
        background: red;
        color: white;
        border: none;
        border-radius: 50%;
        width: 22px;
        height: 22px;
        font-size: 12px;
        cursor: pointer;
    }
</style>

<div class="card shadow-sm">
    <div class="card-header">
        <h5 class="mb-0">Edit Wisata</h5>
    </div>

    <form id="form-edit" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="card-body">

            {{-- ====================== --}}
            {{-- MULTI IMAGE PREVIEW --}}
            {{-- ====================== --}}
            <div class="mb-3">
                <label class="form-label fw-bold">Gambar Wisata</label><br>

                <div class="mb-2">
                    <input type="file" id="edit-images" name="images[]" class="form-control" multiple accept="image/*">
                    <small class="text-muted">Anda dapat memilih banyak gambar sekaligus.</small>
                </div>

                <p class="fw-bold mt-2 mb-1">Gambar Lama:</p>
                <div id="old-images">
                    @if ($data->images)
                        @foreach ($data->images as $img)
                            <div class="img-wrapper old-image" data-file="{{ $img }}">
                                <img src="{{ asset('storage/'.$img) }}" class="preview-img">
                                <button type="button" class="btn-remove-image remove-old" data-name="{{ $img }}">×</button>
                            </div>
                        @endforeach
                    @endif
                </div>

                <p class="fw-bold mt-3 mb-1">Preview Gambar Baru:</p>
                <div id="new-preview"></div>

                <input type="hidden" id="hapus_images" name="hapus_images">
            </div>

            {{-- NAMA --}}
            <div class="mb-3">
                <label class="form-label">Nama Wisata</label>
                <input type="text" name="title" class="form-control" value="{{ $data->title }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Deskripsi</label>
                <input type="text" name="description" class="form-control" value="{{ $data->description }}" required>
            </div>

            {{-- HARGA --}}
            <div class="mb-3">
                <label class="form-label">Harga (Rp)</label>
                <input type="number" name="price" class="form-control" value="{{ $data->price }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Label Harga</label>
                <input type="text" name="price_label" class="form-control" value="{{ $data->price_label }}" required>
            </div>

            {{-- INCLUDE --}}
            <div class="mb-3">
                <label class="form-label">Include</label>
                <textarea name="include" rows="3" class="form-control">{{ $data->include }}</textarea>
            </div>

            {{-- MAPS --}}
            <div class="mb-3">
                <label class="form-label">Maps URL</label>
                <input type="text" name="map_url" class="form-control" value="{{ $data->map_url }}">
            </div>

            {{-- KONTAK --}}
            <div class="mb-3">
                <label class="form-label">Kontak</label>
                <select name="contact_id" id="edit-contact" class="form-select" required>
                    <option value="">-- Pilih Kontak --</option>
                    @foreach ($contact as $c)
                        <option value="{{ $c->id_contact }}" {{ $c->id_contact == $data->id_contact ? 'selected' : '' }}>
                            {{ $c->nama }} ({{ $c->no_hp }})
                        </option>
                    @endforeach
                </select>
            </div>

        </div>

        <div class="card-footer text-end">
            <button type="submit" class="btn btn-warning">Update</button>
        </div>
    </form>

</div>

@endsection

@push('custom-js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

// ===================================
let hapusList     = [];
let newFiles      = [];
let previewArea   = document.getElementById("new-preview");
let inputImages   = document.getElementById("edit-images");
// ===================================


// HAPUS GAMBAR LAMA
document.querySelectorAll(".remove-old").forEach(btn => {
    btn.addEventListener("click", function () {
        let filename = this.getAttribute("data-name");
        hapusList.push(filename);
        document.getElementById("hapus_images").value = JSON.stringify(hapusList);
        this.parentElement.remove();
    });
});


// PREVIEW GAMBAR BARU
inputImages.addEventListener("change", function () {
    [...this.files].forEach(file => {
        if (!file.type.startsWith("image/")) return;
        newFiles.push(file);

        let reader = new FileReader();
        reader.onload = e => {
            let wrap = document.createElement("div");
            wrap.className = "img-wrapper";
            wrap.setAttribute("data-name", file.name);

            wrap.innerHTML = `
                <img src="${e.target.result}" class="preview-img">
                <button type="button" class="btn-remove-image remove-new" data-name="${file.name}">×</button>
            `;

            previewArea.appendChild(wrap);
        };
        reader.readAsDataURL(file);
    });

    this.value = "";
});


// HAPUS FILE BARU
document.addEventListener("click", function (e) {
    if (!e.target.classList.contains("remove-new")) return;
    let name = e.target.getAttribute("data-name");
    newFiles = newFiles.filter(f => f.name !== name);
    document.querySelector(`.img-wrapper[data-name="${name}"]`).remove();
});


// SUBMIT FORM UPDATE
document.getElementById("form-edit").addEventListener("submit", function (e) {
    e.preventDefault();

    let formData = new FormData(this);
    formData.append("_method", "PUT"); // wajib

    // tambahkan file baru
    if (newFiles.length > 0) {
        newFiles.forEach(f => formData.append("images[]", f));
    }

    fetch("{{ route('wisata.update', $data->id) }}", {
        method: "POST", 
        headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
        },
        body: formData
    })
    .then(async res => {
        let text = await res.text();
        try { return JSON.parse(text); }
        catch { throw new Error("Server tidak mengembalikan JSON\n\n" + text); }
    })
    .then(res => {
        if (res.success) {
            Swal.fire("Berhasil!", "Data wisata berhasil diperbarui.", "success")
                .then(() => location.href = "{{ route('wisata.index') }}");
        } else {
            Swal.fire("Error", res.message ?? "Terjadi kesalahan.", "error");
        }
    })
    .catch(err => {
        Swal.fire("Error", err.message, "error");
    });

});

</script>
@endpush
