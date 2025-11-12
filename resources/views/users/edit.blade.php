@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2>Agregar nuevo usuario</h2>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('users.store') }}">
                        {{-- 1. CSRF Protection --}}
                        @csrf

                        {{-- 2. Name Field --}}
                        <div class="mb-3">
                            <label for="name" class="form-label"><strong>Nombre</strong></label>
                            <input
                                type="text"
                                class="form-control @error('name') is-invalid @enderror"
                                id="name"
                                name="name"
                                value="{{ old('name') }}"
                                required
                            >
                            {{-- Validation Feedback --}}
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- 3. Email Field --}}
                        <div class="mb-3">
                            <label for="email" class="form-label"><strong>Email</strong></label>
                            <input
                                type="email"
                                class="form-control @error('email') is-invalid @enderror"
                                id="email"
                                name="email"
                                value="{{ old('email') }}"
                                required
                            >
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        {{-- 3. Role Field --}}
                        <div class="mb-3">
                            <label for="role" class="form-label"><strong>Role</strong></label>
                            <select
                                class="form-control"
                                id="role"
                                name="role"
                                required
                            >
                            <option value="">Select a Role</option>
                            @foreach ($roles as $id => $name)
                                <option value="{{ $id }}" @if ($id == $user->role_id) selected @endif>
                                    {{ $name }}
                                </option>
                            @endforeach
                        </select>
                            
                        </div>

                        {{-- 4. Password Field --}}
                        <div class="mb-3">
                            <label for="password" class="form-label"><strong>Clave</strong></label>
                            <input
                                type="password"
                                class="form-control @error('password') is-invalid @enderror"
                                id="password"
                                name="password"
                                required
                            >
                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- 5. Password Confirmation Field --}}
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label"><strong>Confirmar Clave</strong></label>
                            <input
                                type="password"
                                class="form-control"
                                id="password_confirmation"
                                name="password_confirmation"
                                required
                            >
                            {{-- Note: Laravel's 'confirmed' rule links this to the 'password' field error. --}}
                        </div>

                        {{-- 6. Submit Button --}}
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Create User</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection