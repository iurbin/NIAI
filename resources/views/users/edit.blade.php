@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2>Editar información del usuario</h2>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('users.update', $user) }}">
                        {{-- 1. CSRF Protection --}}
                        @csrf
                        @method('PUT')
                        

                        {{-- 2. Name Field --}}
                        <div class="mb-3">
                            <label for="name" class="form-label"><strong>Nombre</strong></label>
                            <input
                                type="text"
                                class="form-control @error('name') is-invalid @enderror"
                                id="name"
                                name="name"
                                value="{{$user->name}}"
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
                                value="{{ $user->email }}"
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
                                <option value="{{ $name }}" @if ($id == $user->role_id) selected @endif>
                                    {{ $name }}
                                </option>
                            @endforeach
                        </select>
                            
                        </div>

                        

                        {{-- 6. Submit Button --}}
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Actualizar usuario</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection