@extends('admin.layouts')

@section('title', 'Edit Kendaraan')

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
        <h5 class="mb-0">Edit Kendaraan</h5>
    </div>

    <form id="form-edit" enctype="multipart/form-data">
        @csrf

        <div class="card-body">

            {{-- ====================== --}}
            {{-- MULTI IMAGE PREVIEW --}}
            {{-- ====================== --}}
            <div class="mb-3">
                <label class="form-label fw-bold">Gambar Kendaraan</label><br>

                <!-- INPUT FILE -->
                <div class="mb-2">
                    <input type="file" id="edit-images" name="images[]" class="form-control" multiple accept="image/*">
                    <small class="text-muted">Anda dapat memilih banyak gambar sekaligus.</small>
                </div>

                <!-- OLD IMAGES -->
                <p class="fw-bold mt-2 mb-1">Gambar Lama:</p>
                <div id="old-images">
                    @if ($data->images)
                        @foreach ($data->images as $img)
                            <div class="img-wrapper old-image" data-file="{{ $img }}">
                                <img src="{{ asset('storage/'.$img) }}" class="preview-img">
                                <button type="button" class="btn-remove-image" onclick="hapusGambarLama('{{ $img }}')">×</button>
                            </div>
                        @endforeach
                    @endif
                </div>

                <!-- NEW PREVIEW -->
                <p class="fw-bold mt-3 mb-1">Preview Gambar Baru:</p>
                <div id="new-preview"></div>

                <input type="hidden" id="hapus_images" name="hapus_images">
            </div>

            {{-- KATEGORI --}}
            <div class="mb-3">
                <label class="form-label">Kategori</label>
                <select name="id_kategori" id="edit-kategori" class="form-select">
                    <option value="">-- Pilih Kategori --</option>
                    @foreach ($kategori as $k)
                        <option value="{{ $k->id_category }}" 
                            {{ $k->id_category == $data->id_kategori ? 'selected' : '' }}>
                            {{ $k->kategori }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- NAMA --}}
            <div class="mb-3">
                <label class="form-label">Nama Kendaraan</label>
                <input type="text" id="edit-nama" name="nama_kendaraan" class="form-control" 
                    value="{{ $data->nama_kendaraan }}">
            </div>

            {{-- KAPASITAS & HARGA --}}
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Kapasitas (orang)</label>
                    <input type="number" id="edit-kapasitas" name="kapasitas" class="form-control"
                        value="{{ $data->kapasitas }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Harga (Rp)</label>
                    <input type="number" id="edit-harga" name="harga" class="form-control"
                        value="{{ $data->harga }}">
                </div>
            </div>

            {{-- FASILITAS --}}
            <div class="mb-3">
                <label class="form-label">Fasilitas</label>
                <textarea id="edit-fasilitas" name="fasilitas" rows="3" class="form-control">{{ $data->fasilitas }}</textarea>
            </div>

            {{-- KONTAK --}}
            <div class="mb-3">
                <label class="form-label">Kontak</label>
                <select name="id_contact" id="edit-contact" class="form-select">
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

let hapusList = [];
let newFiles = []; // ← file baru disimpan di sini

/* ========== HAPUS GAMBAR LAMA ========== */
function hapusGambarLama(file) {
    hapusList.push(file);
    document.getElementById("hapus_images").value = JSON.stringify(hapusList);
    document.querySelector(`[data-file="${file}"]`).remove();
}

/* ========== PREVIEW GAMBAR BARU (APPEND, TIDAK MENGHAPUS SEBELUMNYA) ========== */
document.getElementById("edit-images").addEventListener("change", function () {

    const previewBaru = document.getElementById("new-preview");

    [...this.files].forEach(file => {

        newFiles.push(file); // ← tambahkan ke array, tidak replace

        let reader = new FileReader();
        reader.onload = e => {

            let div = document.createElement("div");
            div.classList.add("img-wrapper");

            div.innerHTML = `
                <img src="${e.target.result}" class="preview-img">
                <button type="button" class="btn-remove-image" onclick="hapusGambarBaru('${file.name}')">×</button>
            `;

            previewBaru.appendChild(div);
        };

        reader.readAsDataURL(file);
    });

    this.value = ""; // reset input supaya bisa pilih gambar sama berkali-kali
});

/* ========== HAPUS GAMBAR BARU ========== */
function hapusGambarBaru(filename) {
    newFiles = newFiles.filter(f => f.name !== filename);
    document.querySelector(`#new-preview button[onclick="hapusGambarBaru('${filename}')"]`).parentElement.remove();
}

/* ========== SUBMIT UPDATE ========== */
document.getElementById("form-edit").addEventListener("submit", function (e) {
    e.preventDefault();

    let formData = new FormData(this);

    // hapus input file default agar tidak double
    formData.delete("images[]");

    // tambahkan file baru dari array
    newFiles.forEach(f => formData.append("images[]", f));

    formData.set("hapus_images", JSON.stringify(hapusList));

    fetch("{{ route('admin.kendaraan.update', $data->id_vehicle) }}", {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
        },
        body: formData
    })
    .then(res => res.json())
    .then(res => {
        if (res.success) {
            Swal.fire("Berhasil!", "Data kendaraan diperbarui.", "success")
                .then(() => location.href = "{{ route('admin.kendaraan.index') }}");
        } else {
            Swal.fire("Error", "Gagal update.", "error");
        }
    })
    .catch(err => console.error(err));
});

</script>
@endpush
