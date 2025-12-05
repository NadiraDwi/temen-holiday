@extends('admin.layouts')

@section('title', 'Kelola Profil')

@section('content')

<style>
    .profile-card {
        background: #fff;
        padding: 25px;
        border-radius: 12px;
        border: 1px solid #e5e7eb;
        border-left: 5px solid #3b82f6;
    }
</style>

<div class="page-header mb-3">
    <h3 class="fw-bold">Kelola Profil</h3>
</div>

@php
    $user = Auth::guard('admin')->user();
@endphp

{{-- WARNING: PASSWORD BELUM PERNAH DIGANTI --}}
@if ($user->created_at == $user->updated_at)
<div class="alert alert-warning d-flex align-items-center p-3 mb-4" style="border-left: 6px solid #f59e0b;">
    <i class="bi bi-exclamation-triangle-fill me-3" style="font-size: 20px; color:#f59e0b;"></i>
    <div>
        <strong>Keamanan Akun!</strong><br>
        Anda belum pernah mengubah password sejak akun dibuat.
        <a href="{{ route('admin.profile.password') }}" class="fw-bold text-decoration-underline">
            Ganti password sekarang
        </a>
    </div>
</div>
@endif

<div class="profile-card">

    {{-- SUCCESS ALERT --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- FORM EDIT PROFILE --}}
    <form action="{{ route('admin.profile.update') }}" method="POST">
        @csrf

        <div class="row g-3">
            <div class="col-md-9">

                {{-- NAMA --}}
                <div class="mb-3">
                    <label class="form-label">Nama Lengkap</label>
                    <input 
                        type="text"
                        name="name"
                        value="{{ old('name', $user->name) }}"
                        class="form-control @error('name') is-invalid @enderror"
                        required
                    >
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- EMAIL --}}
                <div class="mb-3">
                    <label class="form-label">Email Login</label>
                    <input 
                        type="email"
                        name="email"
                        value="{{ old('email', $user->email) }}"
                        class="form-control @error('email') is-invalid @enderror"
                        required
                    >
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- BUTTONS --}}
                <div class="d-flex gap-2 mt-3">
                    <button class="btn btn-primary px-4">
                        Simpan Perubahan
                    </button>

                    <a href="{{ route('admin.profile.password') }}" class="btn btn-outline-primary px-4">
                        Ubah Password
                    </a>
                </div>

            </div>
        </div>

    </form>

</div>

@endsection
