@extends('admin.layouts')

@section('title', 'Detail Open Trip')

@section('content')

<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <h4>Detail Open Trip</h4>
            </div>
        </div>
    </div>
</div>

<a href="{{ route('trip.index') }}" class="btn btn-secondary mb-3">
    ← Kembali
</a>

{{-- ======================== CARD UTAMA ======================== --}}
<div class="card p-4 shadow-sm mb-4">

    <div class="row">
        {{-- LEFT: COVER IMAGE --}}
        <div class="col-md-5">
            {{-- CLICKABLE IMAGE --}}
            @if($trip->cover_image)
                <img src="{{ asset('storage/opentrip/' . $trip->cover_image) }}"
                    class="img-fluid rounded shadow-sm"
                    style="width:100%; max-height:350px; object-fit:cover; cursor:pointer;"
                    data-bs-toggle="modal"
                    data-bs-target="#modalFullscreenImage">
            @else
                <div class="bg-light p-5 text-center rounded">Tidak ada gambar</div>
            @endif
        </div>

        {{-- RIGHT: DETAIL --}}
        <div class="col-md-7">
            <h3>{{ $trip->title }}</h3>

            <p class="mt-3"><strong>Deskripsi:</strong><br>
                {{ $trip->description ?? '-' }}
            </p>

            <p class="mt-3"><strong>Harga:</strong><br>
                Rp {{ number_format($trip->price, 0, ',', '.') }}
                @if($trip->price_label)
                    ({{ $trip->price_label }})
                @endif
            </p>

            <p class="mt-3"><strong>Meeting Point:</strong><br>
                {{ $trip->meeting_point ?? '-' }}
            </p>

            <p class="mt-3"><strong>Include / Fasilitas:</strong><br>
                {!! nl2br(e($trip->include)) !!}
            </p>

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3>{{ $trip->nama_trip }}</h3>

                <div>
                    <a href="{{ route('trip.edit', $trip->id) }}" class="btn btn-warning btn-sm">
                        Edit Trip
                    </a>

                    <form action="{{ route('trip.destroy', $trip->id) }}" method="POST" class="d-inline" id="formDeleteTrip">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">
                            Hapus Trip
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>


{{-- ======================== CARD DESTINASI ======================== --}}
<div class="card p-4 shadow-sm mb-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5>Destinasi</h5>
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambahDestinasi">
            + Tambah Destinasi
        </button>
    </div>

    @if($trip->destinations->count() > 0)
        <ul class="list-group">
            @foreach($trip->destinations as $item)
                <li class="list-group-item d-flex justify-content-between">
                    <div>
                        <strong>{{ $item->name }}</strong>
                        <br>
                        <small class="text-muted">{{ $item->category ?? '' }}</small>
                    </div>

                    <form action="{{ route('trip.destinasi.delete', $item->id) }}"
                          method="POST"
                          onsubmit="return confirm('Hapus destinasi ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="border-0 bg-transparent text-danger fs-5 p-0" title="Hapus">
                        ✕
                    </button>
                    </form>
                </li>
            @endforeach
        </ul>
    @else
        <p class="text-muted">Belum ada destinasi.</p>
    @endif

</div>


{{-- ======================== CARD JADWAL ======================== --}}
<div class="card p-4 shadow-sm mb-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5>Jadwal Keberangkatan</h5>
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambahJadwal">
            + Tambah Jadwal
        </button>
    </div>

    @if($trip->schedules->count() > 0)
        <ul class="list-group">
            @foreach($trip->schedules as $schedule)
                <li class="list-group-item d-flex justify-content-between">

                    <span>
                        {{ \Carbon\Carbon::parse($schedule->start_date)->format('d M Y') }}
                        -
                        {{ \Carbon\Carbon::parse($schedule->end_date)->format('d M Y') }}
                    </span>

                    <form action="{{ route('trip.jadwal.delete', $schedule->id) }}"
                          method="POST"
                          onsubmit="return confirm('Hapus jadwal ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="border-0 bg-transparent text-danger fs-5 p-0" title="Hapus">
                        ✕
                    </button>
                    </form>
                </li>
            @endforeach
        </ul>
    @else
        <p class="text-muted">Belum ada jadwal keberangkatan.</p>
    @endif

</div>

<div class="card p-4 shadow-sm mb-4">

    <div class="d-flex justify-content-between mb-3">
        <h5>Itinerary</h5>
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambahHari">
            + Tambah Hari
        </button>
    </div>

    @foreach($trip->itineraries as $hari)
        <div class="border rounded p-3 mb-3">

            <div class="d-flex justify-content-between">
                <h6>{{ $hari->day_title }}</h6>

                <form action="{{ route('trip.itinerary.delete', $hari->id) }}"
                      method="POST"
                      onsubmit="return confirm('Hapus hari ini?')">
                    @csrf @method('DELETE')
                    <button class="border-0 bg-transparent text-danger fs-5 p-0" title="Hapus">
                        ✕
                    </button>
                </form>
            </div>

            <ul class="mt-2">
                @foreach($hari->items as $item)
                    <li class="d-flex justify-content-between">
                        <span>
                            <strong>{{ $item->time ?? '-' }}</strong> :
                            {{ $item->activity }}
                        </span>

                        <form action="{{ route('trip.itinerary.item.delete', $item->id) }}"
                              method="POST"
                              onsubmit="return confirm('Hapus kegiatan ini?')">
                            @csrf @method('DELETE')
                            <button class="border-0 bg-transparent text-danger fs-5 p-0" title="Hapus">
                        ✕
                    </button>
                        </form>
                    </li>
                @endforeach
            </ul>

            <button class="btn btn-success btn-sm mt-2"
                    data-bs-toggle="modal"
                    data-bs-target="#modalTambahItem{{ $hari->id }}">
                + Tambah Aktivitas
            </button>

        </div>

        {{-- MODAL TAMBAH ITEM --}}
        <div class="modal fade" id="modalTambahItem{{ $hari->id }}">
            <div class="modal-dialog">
                <form class="modal-content" action="{{ route('trip.itinerary.item.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="itinerary_id" value="{{ $hari->id }}">

                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Aktivitas</h5>
                        <button class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        <div class="mb-3">
                            <label>Waktu (opsional)</label>
                            <input type="time" name="time" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label>Aktivitas</label>
                            <textarea name="activity" class="form-control" required></textarea>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-primary">Simpan</button>
                    </div>

                </form>
            </div>
        </div>

    @endforeach

</div>

{{-- ======================== MODAL TAMBAH DESTINASI ======================== --}}
<div class="modal fade" id="modalTambahDestinasi">
    <div class="modal-dialog">
        <form class="modal-content" action="{{ route('trip.destinasi.store') }}" method="POST">
            @csrf
            <input type="hidden" name="open_trip_id" value="{{ $trip->id }}">

            <div class="modal-header">
                <h5 class="modal-title">Tambah Destinasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <div class="mb-3">
                    <label>Nama Destinasi</label>
                    <input type="text" name="name" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Kategori (opsional)</label>
                    <input type="text" name="category" class="form-control">
                </div>

            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>

        </form>
    </div>
</div>

{{-- ======================== MODAL TAMBAH JADWAL ======================== --}}
<div class="modal fade" id="modalTambahJadwal">
    <div class="modal-dialog">
        <form class="modal-content" action="{{ route('trip.jadwal.store') }}" method="POST">
            @csrf
            <input type="hidden" name="open_trip_id" value="{{ $trip->id }}">

            <div class="modal-header">
                <h5 class="modal-title">Tambah Jadwal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <div class="mb-3">
                    <label>Tanggal Mulai</label>
                    <input type="date" name="start_date" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Tanggal Selesai</label>
                    <input type="date" name="end_date" class="form-control" required>
                </div>

            </div>

            <div class="modal-footer">
                <button class="btn btn-primary">Simpan</button>
            </div>

        </form>
    </div>
</div>

{{-- ======================== MODAL FULLSCREEN IMAGE ======================== --}}
<div class="modal fade" id="modalFullscreenImage" tabindex="-1">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content bg-dark">
            
            <div class="modal-header border-0">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                    ✕ Tutup
                </button>
            </div>

            <div class="modal-body p-0 d-flex justify-content-center align-items-center">
                <img src="{{ asset('storage/opentrip/' . $trip->cover_image) }}"
                     class="img-fluid"
                     style="max-height:100vh; object-fit:contain;">
            </div>

        </div>
    </div>
</div>

{{-- ======================== MODAL TAMBAH HARI ======================== --}}
<div class="modal fade" id="modalTambahHari">
    <div class="modal-dialog">
        <form class="modal-content" action="{{ route('trip.itinerary.store') }}" method="POST">
            @csrf
            <input type="hidden" name="open_trip_id" value="{{ $trip->id }}">

            <div class="modal-header">
                <h5 class="modal-title">Tambah Hari</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <div class="mb-3">
                    <label>Judul Hari</label>
                    <input type="text" name="day_title" class="form-control"
                           placeholder="Contoh: Hari Ke 1" required>
                </div>

            </div>

            <div class="modal-footer">
                <button class="btn btn-primary">Simpan</button>
            </div>

        </form>
    </div>
</div>

@endsection

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.getElementById("formDeleteTrip").addEventListener("submit", function(e) {
    e.preventDefault();

    Swal.fire({
        title: "Hapus Trip?",
        text: "Seluruh detail termasuk destinasi & jadwal juga akan terhapus.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Ya, hapus!"
    }).then((result) => {
        if (result.isConfirmed) {
            e.target.submit();
        }
    });
});
</script>
