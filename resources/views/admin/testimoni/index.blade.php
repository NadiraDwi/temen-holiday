@extends('admin.layouts')

@section('title', 'Testimoni')

@section('content')

{{-- BOOTSTRAP ICONS --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

{{-- SWEETALERT2 --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    .testi-card {
        border-radius: 12px;
        border: 1px solid #eee;
        padding: 18px;
        background: #fff;
        margin-bottom: 20px;
        transition: .2s;
    }
    .testi-card:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    }
    .testi-name {
        font-weight: 600;
        font-size: 1.1rem;
        color: #222;
    }
    .testi-stars i {
        font-size: 17px;
        color: #ffc107;
        margin-right: 2px;
    }
    .testi-images img {
        width: 85px;
        height: 85px;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid #ddd;
        margin-right: 6px;
        margin-bottom: 6px;
    }
    @media(max-width: 768px){
        .testi-images img {
            width: 70px;
            height: 70px;
        }
    }
</style>

<div class="page-header">
    <div class="page-block">
        <ul class="breadcrumb">
            <li class="breadcrumb-item">Testimoni</li>
        </ul>
    </div>
</div>

<h2 class="mb-4">Testimoni Pelanggan</h2>

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="row">

@foreach ($testimoni as $t)

@php
    $images = is_array($t->images) ? $t->images : [];
@endphp

<div class="col-lg-6">
    <div class="testi-card">

        {{-- NAMA --}}
        <div class="testi-name">{{ $t->nama_user }}</div>

        {{-- RATING FASILITAS --}}
        <div class="mt-1">
            <strong>Fasilitas:</strong>
            <span class="testi-stars text-warning">
                @for ($i = 1; $i <= 5; $i++)
                    <i class="bi {{ $i <= $t->rating_fasilitas ? 'bi-star-fill' : 'bi-star' }}"></i>
                @endfor
            </span>
        </div>

        {{-- RATING HARGA --}}
        <div>
            <strong>Harga:</strong>
            <span class="testi-stars text-warning">
                @for ($i = 1; $i <= 5; $i++)
                    <i class="bi {{ $i <= $t->rating_harga ? 'bi-star-fill' : 'bi-star' }}"></i>
                @endfor
            </span>
        </div>

        {{-- PESAN --}}
        <p class="mt-2">{{ Str::limit($t->pesan, 150) }}</p>

        {{-- GAMBAR --}}
        @if ($images)
        <div class="testi-images d-flex flex-wrap">
            @foreach ($images as $img)
                <img src="{{ asset('storage/' . $img) }}">
            @endforeach
        </div>
        @endif

        {{-- TOMBOL --}}
        <div class="d-flex gap-2">

            {{-- TOMBOL BALAS --}}
            <button class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#replyModal{{ $t->id_testimoni }}">
                <i class="bi bi-chat-left-text"></i>
            </button>

            {{-- DELETE --}}
            <button class="btn btn-sm btn-danger btn-delete" data-id="{{ $t->id_testimoni }}">
                <i class="bi bi-trash"></i>
            </button>

            {{-- FORM HIDDEN DELETE --}}
            <form id="deleteForm{{ $t->id_testimoni }}" action="{{ route('testimoni.delete', $t->id_testimoni) }}" method="POST" style="display:none;">
                @csrf
                @method('DELETE')
            </form>

        </div>

    </div>
</div>

{{-- ========== MODAL DETAIL & REPLY ========== --}}
<div class="modal fade" id="replyModal{{ $t->id_testimoni }}" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Balas Testimoni</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">

        <h5 class="fw-bold">{{ $t->nama_user }}</h5>

        <div class="mb-1">
            <strong>Fasilitas:</strong>
            <span class="text-warning">
                @for ($i = 1; $i <= 5; $i++)
                    <i class="bi {{ $i <= $t->rating_fasilitas ? 'bi-star-fill' : 'bi-star' }}"></i>
                @endfor
            </span>
        </div>

        <div class="mb-2">
            <strong>Harga:</strong>
            <span class="text-warning">
                @for ($i = 1; $i <= 5; $i++)
                    <i class="bi {{ $i <= $t->rating_harga ? 'bi-star-fill' : 'bi-star' }}"></i>
                @endfor
            </span>
        </div>

        <p>{{ $t->pesan }}</p>

        @if ($images)
        <div class="testi-images d-flex flex-wrap mb-3">
            @foreach ($images as $img)
                <img src="{{ asset('storage/' . $img) }}">
            @endforeach
        </div>
        @endif

        <hr>

        <form action="{{ route('testimoni.reply', $t->id_testimoni) }}" method="POST">
            @csrf
            <label class="fw-semibold">Balasan Admin</label>
            <textarea name="reply_admin" class="form-control" rows="3" required>{{ $t->reply_admin }}</textarea>

            <button class="btn btn-primary mt-3 w-100">Kirim Balasan</button>
        </form>

      </div>
    </div>
  </div>
</div>

@endforeach

</div>

@endsection


@push('custom-js')

<script>
    // SweetAlert2 Delete Confirmation
    document.querySelectorAll('.btn-delete').forEach(btn => {
        btn.addEventListener('click', function() {
            let id = this.dataset.id;
            Swal.fire({
                title: "Hapus Testimoni?",
                text: "Data tidak dapat dikembalikan setelah dihapus.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#6c757d",
                confirmButtonText: "Hapus",
                cancelButtonText: "Batal"
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(`deleteForm${id}`).submit();
                }
            });
        });
    });
</script>

@endpush
