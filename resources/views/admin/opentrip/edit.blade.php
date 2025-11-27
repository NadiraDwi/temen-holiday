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

    <form action="{{ route('trip.update', $trip->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Upload Gambar -->
        <div class="mb-3 text-center">
            <label class="form-label fw-bold">Gambar Open Trip</label>

            <div id="upload-area" class="upload-box">
                <div class="upload-placeholder {{ $trip->cover_image ? 'd-none' : '' }}">
                    <i class="fas fa-cloud-upload-alt fa-2x mb-2 text-primary"></i>
                    <p>Browse Files to upload</p>
                </div>

                <img id="preview-image"
                     class="preview-img {{ $trip->cover_image ? '' : 'd-none' }}"
                     src="{{ $trip->cover_image ? asset('storage/opentrip/'.$trip->cover_image) : '' }}"
                     alt="Preview">
            </div>

            <input type="file" name="cover_image" id="gambar-input" class="d-none" accept="image/*">

            <div class="d-flex justify-content-between mt-2">
                <span id="file-name" class="small text-muted">
                    {{ $trip->cover_image ? basename($trip->cover_image) : 'No selected file' }}
                </span>

                <button type="button"
                        id="btn-remove"
                        class="btn btn-sm btn-outline-danger {{ $trip->cover_image ? '' : 'd-none' }}">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Nama Trip</label>
            <input type="text" name="title" class="form-control" value="{{ $trip->title }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Deskripsi</label>
            <textarea name="description" class="form-control" rows="3">{{ $trip->description }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Harga</label>
            <input type="number" name="price" class="form-control" value="{{ $trip->price }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Price Label (opsional)</label>
            <input type="text" name="price_label" class="form-control"
                   value="{{ $trip->price_label }}" placeholder="Contoh: 685K / pax">
        </div>

        <div class="mb-3">
            <label class="form-label">Meeting Point</label>
            <input type="text" name="meeting_point" class="form-control" value="{{ $trip->meeting_point }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Include (Fasilitas)</label>
            <textarea name="include" class="form-control" rows="3">{{ $trip->include }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Kontak (Opsional)</label>
            <select name="id_contact" class="form-control">
                <option value="">-- Pilih Kontak --</option>
                @foreach ($contacts as $c)
                    <option value="{{ $c->id_contact }}"
                        {{ $trip->id_contact == $c->id_contact ? 'selected' : '' }}>
                        {{ $c->nama }} - {{ $c->no_hp }}
                    </option>
                @endforeach
            </select>
        </div>

        <button class="btn btn-primary px-4">Update</button>
        <a href="{{ route('trip.index') }}" class="btn btn-secondary px-4">Kembali</a>

    </form>

</div>

@endsection

@push('custom-js')
<script>
// =========================
// EDIT IMAGE HANDLER
// =========================
const uploadArea   = document.getElementById('upload-area');
const fileInput    = document.getElementById('gambar-input');
const previewImg   = document.getElementById('preview-image');
const fileName     = document.getElementById('file-name');
const removeBtn    = document.getElementById('btn-remove');
const placeholder  = uploadArea.querySelector('.upload-placeholder');

uploadArea.addEventListener('click', () => fileInput.click());

fileInput.addEventListener('change', function () {
    const file = this.files[0];
    if (file) {
        const url = URL.createObjectURL(file);
        previewImg.src = url;
        previewImg.classList.remove('d-none');
        placeholder.classList.add('d-none');
        fileName.textContent = file.name;
        removeBtn.classList.remove('d-none');
    }
});

// tombol hapus gambar (reset)
removeBtn.addEventListener('click', function () {
    fileInput.value = '';
    previewImg.src = '';
    previewImg.classList.add('d-none');
    placeholder.classList.remove('d-none');
    fileName.textContent = "No selected file";
    removeBtn.classList.add('d-none');
});
</script>
@endpush
