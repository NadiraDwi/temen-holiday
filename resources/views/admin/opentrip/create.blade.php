@extends('admin.layouts')

@section('title', 'Create Open Trip')

@section('content')

<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <h4>Create Open Trip</h4>
            </div>
        </div>
    </div>
</div>

<div class="card p-4 shadow-sm">

    <form action="{{ route('trip.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Upload Multi Image -->
        <div class="mb-3">
            <label class="form-label fw-bold">Gambar Open Trip (bisa lebih dari 1)</label>

            <div class="multi-upload-wrapper">

                <div id="preview-container" class="d-flex flex-wrap gap-2 mb-2"></div>

                @error('images')
                    <small class="text-danger d-block">{{ $message }}</small>
                @enderror
                @error('images.*')
                    <small class="text-danger d-block">{{ $message }}</small>
                @enderror

                <div id="upload-box" class="upload-box text-center">
                    <i class="fas fa-cloud-upload-alt fa-2x mb-2 text-primary"></i>
                    <p>Browse files to upload</p>
                </div>

            </div>

            <input type="file" name="images[]" id="gambar-input" class="d-none" accept="image/*" multiple>
        </div>

        <div class="mb-3">
            <label class="form-label">Nama Trip</label>
            <input type="text" name="title" value="{{ old('title') }}" class="form-control">
            @error('title')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Deskripsi</label>
            <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
            @error('description')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Harga</label>
            <input type="number" name="price" value="{{ old('price') }}" class="form-control">
            @error('price')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Price Label (opsional)</label>
            <input type="text" name="price_label" value="{{ old('price_label') }}" class="form-control" placeholder="Contoh: 685K / pax">
            @error('price_label')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Meeting Point</label>
            <input type="text" name="meeting_point" value="{{ old('meeting_point') }}" class="form-control" placeholder="Contoh: Malang, Surabaya...">
            @error('meeting_point')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Include (Fasilitas)</label>
            <textarea name="include" class="form-control" rows="3" placeholder="Contoh: Transportasi, makan, tiket wisata...">{{ old('include') }}</textarea>
            @error('include')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Kontak (Opsional)</label>
            <select name="id_contact" class="form-control">
                <option value="">-- Pilih Kontak --</option>
                @foreach ($contacts as $c)
                    <option value="{{ $c->id_contact }}" {{ old('id_contact') == $c->id_contact ? 'selected' : '' }}>
                        {{ $c->nama }} - {{ $c->no_hp }}
                    </option>
                @endforeach
            </select>

            @error('id_contact')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <button class="btn btn-primary px-4">Simpan</button>
        <a href="{{ route('trip.index') }}" class="btn btn-secondary px-4">Kembali</a>

    </form>

</div>

@endsection

@push('custom-css')
<style>
.upload-box {
    width: 150px;
    height: 120px;
    border: 2px dashed #bbb;
    border-radius: 8px;
    cursor: pointer;
    padding-top: 25px;
}

.preview-item {
    position: relative;
}

.preview-img {
    width: 150px;
    height: 120px;
    object-fit: cover;
    border-radius: 8px;
    border: 1px solid #ccc;
}

.remove-btn {
    position: absolute;
    top: 5px;
    right: 5px;
    background: rgba(0,0,0,0.6);
    color: white;
    border: none;
    border-radius: 50%;
    width: 25px;
    height: 25px;
    cursor: pointer;
}
</style>
@endpush

@push('custom-js')
<script>

const uploadBox = document.getElementById('upload-box');
const fileInput = document.getElementById('gambar-input');
const previewContainer = document.getElementById('preview-container');

let selectedFiles = [];

// klik area upload
uploadBox.addEventListener('click', () => fileInput.click());

// ketika memilih file baru
fileInput.addEventListener('change', function () {
    [...this.files].forEach((file) => {
        selectedFiles.push(file);

        const index = selectedFiles.length - 1;
        const url = URL.createObjectURL(file);

        addPreview(url, index);
    });

    rebuildFileList();
});

// Tambah preview
function addPreview(imgUrl, index) {
    const div = document.createElement('div');
    div.className = "preview-item";
    div.dataset.index = index;

    div.innerHTML = `
        <img src="${imgUrl}" class="preview-img">
        <button type="button" class="remove-btn">&times;</button>
    `;

    div.querySelector('.remove-btn').addEventListener('click', () => removeImage(index));

    previewContainer.appendChild(div);
}

// Hapus gambar
function removeImage(index) {
    selectedFiles[index] = null;

    const item = document.querySelector(`.preview-item[data-index="${index}"]`);
    if (item) item.remove();

    rebuildFileList();
}

// rebuild FileList
function rebuildFileList() {
    const dt = new DataTransfer();

    selectedFiles.forEach(file => {
        if (file !== null) {
            dt.items.add(file);
        }
    });

    fileInput.files = dt.files;
}

</script>
@endpush
