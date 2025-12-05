@extends('admin.layouts')

@section('title', 'Ganti Password')

@section('content')

<style>
    .password-card {
        background: #fff;
        padding: 25px;
        border-radius: 12px;
        border: 1px solid #e5e7eb;
        border-left: 5px solid #3b82f6;
    }
</style>

<div class="page-header mb-3">
    <h3 class="fw-bold">Ganti Password</h3>
</div>

<div class="password-card">

    {{-- ALERT ERROR --}}
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- ALERT SUCCESS --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('admin.profile.password.update') }}" method="POST">
        @csrf

        {{-- PASSWORD LAMA --}}
        <div class="mb-3">
            <label class="form-label">Password Lama</label>
            <div class="input-group">
                <input 
                    type="password" 
                    name="current_password"
                    id="current_password"
                    class="form-control @error('current_password') is-invalid @enderror" 
                    required
                >
                <span class="input-group-text" onclick="togglePassword('current_password', this)" style="cursor:pointer;">
                    <i class="bi bi-eye-slash"></i>
                </span>
            </div>
            @error('current_password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- PASSWORD BARU --}}
        <div class="mb-3">
            <label class="form-label">Password Baru</label>
            <div class="input-group">
                <input 
                    type="password" 
                    name="new_password"
                    id="new_password"
                    class="form-control @error('new_password') is-invalid @enderror" 
                    required
                >
                <span class="input-group-text" onclick="togglePassword('new_password', this)" style="cursor:pointer;">
                    <i class="bi bi-eye-slash"></i>
                </span>
            </div>
            @error('new_password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- KONFIRM PASSWORD --}}
        <div class="mb-3">
            <label class="form-label">Konfirmasi Password Baru</label>
            <div class="input-group">
                <input 
                    type="password" 
                    name="confirm_new_password"
                    id="confirm_new_password"
                    class="form-control @error('confirm_new_password') is-invalid @enderror" 
                    required
                >
                <span class="input-group-text" onclick="togglePassword('confirm_new_password', this)" style="cursor:pointer;">
                    <i class="bi bi-eye-slash"></i>
                </span>
            </div>
            @error('confirm_new_password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button class="btn btn-primary px-4">
            Update Password
        </button>

    </form>

</div>

{{-- TOGGLE PASSWORD SCRIPT --}}
<script>
function togglePassword(id, el) {
    const input = document.getElementById(id);
    const icon = el.querySelector("i");

    if (input.type === "password") {
        input.type = "text";
        icon.classList.remove("bi-eye-slash");
        icon.classList.add("bi-eye");
    } else {
        input.type = "password";
        icon.classList.remove("bi-eye");
        icon.classList.add("bi-eye-slash");
    }
}
</script>

{{-- BOOTSTRAP ICONS --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

@endsection
