@extends('admin.layouts')

@section('title', 'Dashboard')

@section('content')

<style>
    .stat-box {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 20px 20px 20px 25px;
        transition: .2s;
        border-left: 6px solid #3b82f6;
    }
    .stat-box:hover {
        border-color: #c2c7cf;
        border-left-color: #2563eb;
    }

    .stat-title {
        font-size: 14px;
        font-weight: 600;
        color: #6b7280;
        margin-bottom: 6px;
    }
    .stat-value {
        font-size: 30px;
        font-weight: 700;
        color: #1f2937;
    }

    .section-title {
        font-size: 17px;
        font-weight: 600;
        margin-bottom: 10px;
        color: #374151;
    }

    .content-card {
        background: #fff;
        padding: 25px;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        border-left: 6px solid #3b82f6;
        transition: .2s;
    }
    .content-card:hover {
        border-left-color: #2563eb;
    }
</style>

{{-- HEADER --}}
<div class="page-header mb-3">
    <h3 class="fw-bold mb-0">Dashboard Admin</h3>
</div>

{{-- GET USER ADMIN --}}
@php
    $user = Auth::guard('admin')->user();
@endphp

{{-- WARNING PASSWORD BELUM DIGANTI --}}
@if ($user && $user->created_at == $user->updated_at)
<div class="alert alert-warning d-flex align-items-center p-3 mb-4" style="border-left: 6px solid #f59e0b;">
    <i class="bi bi-exclamation-triangle-fill me-3" style="font-size: 20px; color:#f59e0b;"></i>
    <div>
        <strong>Keamanan Akun!</strong><br>
        Anda belum pernah mengubah password sejak akun dibuat.
        <a href="{{ route('admin.profile.password') }}" class="fw-bold text-decoration-underline">Ganti password sekarang</a>
        untuk melindungi akun Anda.
    </div>
</div>
@endif

{{-- STAT BOX --}}
<div class="row g-3">
    <div class="col-md-4">
        <div class="stat-box">
            <div class="stat-title">Total Kendaraan</div>
            <div class="stat-value">{{ $totalVehicles }}</div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="stat-box">
            <div class="stat-title">Total Wisata</div>
            <div class="stat-value">{{ $totalWisata }}</div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="stat-box">
            <div class="stat-title">Total Open Trip</div>
            <div class="stat-value">{{ $totalOpenTrip }}</div>
        </div>
    </div>
</div>

<hr class="my-3">

{{-- KONTEN DASHBOARD TANPA CHART --}}
<div class="row g-3">

    {{-- LIST KATEGORI KENDARAAN --}}
    <div class="col-md-6">
        <div class="content-card">
            <div class="section-title">Kendaraan per Kategori</div>

            <table class="table table-sm table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>Kategori</th>
                        <th class="text-center" style="width: 120px">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($vehiclesByCategory as $kategori => $total)
                        <tr>
                            <td>{{ $kategori }}</td>
                            <td class="text-center fw-bold">{{ $total }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="text-center text-muted">Tidak ada data kendaraan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- LOG AKTIVITAS ADMIN --}}
    <div class="col-md-6">
        <div class="content-card">
            <div class="section-title">Aktivitas Admin Terakhir</div>

            <ul class="list-group small">
                <li class="list-group-item">
                    <strong>{{ $user->nama_admin }}</strong> login pada:
                    <br>
                    {{ now()->format('d M Y') }}
                </li>
            </ul>
        </div>
    </div>
</div>
<hr class="my-4">

@endsection


{{-- SCRIPTS --}}
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush
