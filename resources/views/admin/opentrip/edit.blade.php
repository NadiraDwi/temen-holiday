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

        <!-- MULTI IMAGE UPLOAD -->
        <div class="mb-3">
            <label class="form-label fw-bold">Gambar Open Trip</label>

            <!-- EXISTING IMAGES -->
            <div class="row" id="existing-images">
                @php
                    $images = is_array($trip->images) ? $trip->images : json_decode($trip->images, true);
                    $images = $images ?? [];
                @endphp

                @foreach ($images as $img)
                    <div class="col-4 mb-3 position-relative image-wrapper">
                        <img src="{{ asset('storage/' . $img) }}"
                             class="img-fluid rounded border preview-small">

                        <button type="button" class="btn btn-danger btn-sm delete-image-btn"
                            data-image="{{ $img }}"
                            style="position:absolute; top:5px; right:10px; z-index:10">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                @endforeach
            </div>

            <!-- NEW IMAGE INPUT -->
            <input type="file" name="images[]" id="new-images"
                   class="form-control mt-2" multiple accept="image/*">

            <!-- PREVIEW NEW IMAGES -->
            <div id="preview-new" class="row mt-3"></div>

            <!-- HIDDEN FIELD -->
            <input type="hidden" name="deleted_images" id="deleted_images">
        </div>

        <div class="mb-3">
            <label class="form-label">Nama Trip</label>
            <input type="text" name="title" class="form-control"
                   value="{{ $trip->title }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Deskripsi</label>
            <textarea name="description" class="form-control" rows="3">{{ $trip->description }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Harga</label>
            <input type="number" name="price" class="form-control"
                   value="{{ $trip->price }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Price Label (opsional)</label>
            <input type="text" name="price_label" class="form-control"
                   value="{{ $trip->price_label }}" placeholder="Contoh: 685K / pax">
        </div>

        <div class="mb-3">
            <label class="form-label">Meeting Point</label>
            <input type="text" name="meeting_point" class="form-control"
                   value="{{ $trip->meeting_point }}">
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

@push('custom-css')
<style>
.preview-small {
    width: 120px;
    height: 90px;
    object-fit: cover;
}
</style>
@endpush

@push('custom-js')
<script>
let deletedList = [];
let selectedFiles = []; // ⬅️ SIMPAN SEMUA FILE BARU

// DELETE OLD IMAGES
document.querySelectorAll('.delete-image-btn').forEach(btn => {
    btn.addEventListener('click', function () {
        const filename = this.dataset.image;
        deletedList.push(filename);

        document.getElementById('deleted_images').value = JSON.stringify(deletedList);
        this.closest('.image-wrapper').remove();
    });
});

// PREVIEW NEW IMAGES (TIDAK MENGHAPUS YANG LAMA)
document.getElementById('new-images').addEventListener('change', function () {
    const preview = document.getElementById('preview-new');

    // Tambah file baru ke array
    Array.from(this.files).forEach(file => {
        selectedFiles.push(file);

        const reader = new FileReader();
        reader.onload = function (e) {
            const col = document.createElement('div');
            col.classList.add('col-4', 'mb-3');
            col.innerHTML = `
                <img src="${e.target.result}" 
                     class="img-fluid rounded border preview-small">
            `;
            preview.appendChild(col);
        };
        reader.readAsDataURL(file);
    });

    // SIMPAN ULANG FILES KE INPUT (karena tidak bisa edit langsung)
    const dataTransfer = new DataTransfer();
    selectedFiles.forEach(f => dataTransfer.items.add(f));
    this.files = dataTransfer.files; // set ulang isi input
});
</script>

@endpush
