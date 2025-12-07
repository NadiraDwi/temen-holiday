@extends('admin.layouts')

@section('title', 'Edit Open Trip')

@section('content')

<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <h4>Edit Open Trip</h4>
            </div>
        </div>
    </div>
</div>

<div class="card p-4 shadow-sm">

    <form action="{{ route('trip.update', $trip->id) }}" 
      method="POST" 
      enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <!-- MULTI IMAGE -->
    <div class="mb-3">
        <label class="form-label fw-bold">Gambar Open Trip (bisa lebih dari 1)</label>

        <!-- EXISTING IMAGES -->
        <div id="preview-container" class="d-flex flex-wrap gap-2 mb-2">
            @php
                $images = is_array($trip->images) ? $trip->images : json_decode($trip->images, true);
                $images = $images ?? [];
            @endphp

            @foreach ($images as $img)
            <div class="preview-item" data-existing="{{ $img }}">
                <img src="{{ asset('storage/'.$img) }}" class="preview-img">
                <button type="button" class="remove-btn remove-old">&times;</button>
            </div>
            @endforeach
        </div>

        <!-- UPLOAD BOX -->
        <div id="upload-box" class="upload-box text-center">
            <i class="fas fa-cloud-upload-alt fa-2x mb-2 text-primary"></i>
            <p>Browse files to upload</p>
        </div>

        <input type="file" name="images[]" id="gambar-input" class="d-none" accept="image/*" multiple>
        <input type="hidden" name="deleted_images" id="deleted_images">

        @error('images.*')
            <small class="text-danger d-block">{{ $message }}</small>
        @enderror
        @error('deleted_images')
            <small class="text-danger d-block">{{ $message }}</small>
        @enderror
    </div>

    <!-- NAMA TRIP -->
    <div class="mb-3">
        <label class="form-label">Nama Trip</label>
        <input type="text" name="title"
               class="form-control @error('title') is-invalid @enderror"
               value="{{ old('title', $trip->title) }}">
        @error('title')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <!-- DESKRIPSI -->
    <div class="mb-3">
        <label class="form-label">Deskripsi</label>
        <textarea name="description" rows="3"
                  class="form-control @error('description') is-invalid @enderror">{{ old('description', $trip->description) }}</textarea>
        @error('description')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <!-- HARGA -->
    <div class="mb-3">
        <label class="form-label">Harga</label>
        <input type="number" name="price"
               class="form-control @error('price') is-invalid @enderror"
               value="{{ old('price', $trip->price) }}">
        @error('price')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <!-- PRICE LABEL -->
    <div class="mb-3">
        <label class="form-label">Price Label (Opsional)</label>
        <input type="text" name="price_label"
               class="form-control @error('price_label') is-invalid @enderror"
               value="{{ old('price_label', $trip->price_label) }}">
        @error('price_label')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <!-- MEETING POINT -->
    <div class="mb-3">
        <label class="form-label">Meeting Point</label>
        <input type="text" name="meeting_point"
               class="form-control @error('meeting_point') is-invalid @enderror"
               value="{{ old('meeting_point', $trip->meeting_point) }}">
        @error('meeting_point')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <!-- INCLUDE -->
    <div class="mb-3">
        <label class="form-label">Include</label>
        <textarea name="include"
                  class="form-control @error('include') is-invalid @enderror"
                  rows="3">{{ old('include', $trip->include) }}</textarea>
        @error('include')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <!-- KONTAK -->
    <div class="mb-3">
        <label class="form-label">Kontak (Opsional)</label>
        <select name="id_contact"
                class="form-control @error('id_contact') is-invalid @enderror">
            <option value="">-- Pilih Kontak --</option>
            @foreach ($contacts as $c)
                <option value="{{ $c->id_contact }}"
                    {{ old('id_contact', $trip->id_contact) == $c->id_contact ? 'selected' : '' }}>
                    {{ $c->nama }} - {{ $c->no_hp }}
                </option>
            @endforeach
        </select>
        @error('id_contact')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <!-- BUTTON -->
    <button class="btn btn-primary px-4">Update</button>
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
const preview = document.getElementById('preview-container');

let selectedFiles = [];
let deletedImages = [];

/* ----- CLICK UPLOAD ----- */
uploadBox.addEventListener('click', () => fileInput.click());

/* ----- ADD NEW IMAGES ----- */
fileInput.addEventListener('change', function () {
    [...this.files].forEach((file) => {
        selectedFiles.push(file);
        const index = selectedFiles.length - 1;
        const url = URL.createObjectURL(file);

        addPreview(url, index, false);
    });

    rebuildFileList();
});

/* ----- ADD PREVIEW ITEM ----- */
function addPreview(imgUrl, index, isOld = false) {
    const div = document.createElement('div');
    div.className = "preview-item";
    div.dataset.index = index;

    div.innerHTML = `
        <img src="${imgUrl}" class="preview-img">
        <button type="button" class="remove-btn">&times;</button>
    `;

    div.querySelector('.remove-btn').addEventListener('click', () => {
        if (isOld) {
            deletedImages.push(div.dataset.existing);
            document.getElementById('deleted_images').value = JSON.stringify(deletedImages);
        } else {
            selectedFiles[index] = null;
            rebuildFileList();
        }
        div.remove();
    });

    preview.appendChild(div);
}

/* ----- REBUILD FILELIST ----- */
function rebuildFileList() {
    const dt = new DataTransfer();

    selectedFiles.forEach(file => {
        if (file !== null) dt.items.add(file);
    });

    fileInput.files = dt.files;
}

/* ----- DELETE EXISTING IMAGES ----- */
document.querySelectorAll('.remove-old').forEach(btn => {
    btn.addEventListener('click', function () {
        const wrapper = this.closest('.preview-item');
        const img = wrapper.dataset.existing;

        deletedImages.push(img);
        document.getElementById('deleted_images').value = JSON.stringify(deletedImages);

        wrapper.remove();
    });
});

</script>
@endpush
