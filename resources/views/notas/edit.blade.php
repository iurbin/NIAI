@extends('layouts.app')

@section('content')

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="p-3">
                    <h2>Agregar nueva publicación</h2>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('notas.update', $nota) }}">
                        {{-- 1. CSRF Protection --}}
                        @csrf

                        {{-- 2. Link Field --}}
                        <div class="mb-3">
                            <label for="link" class="form-label"><strong>Enlace</strong></label>
                            <input
                                type="text"
                                class="form-control @error('link') is-invalid @enderror"
                                id="link"
                                name="link"
                                value="{{ $nota->link }}"
                                placeholder="Enter a URL (e.g., https://...)"
                                required
                            >
                            {{-- Validation Feedback --}}
                            @error('link')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3"><div id="status-box"></div></div>
                        {{-- 3. Title Field --}}
                        <div class="mb-3">
                            <label for="title" class="form-label"><strong>Título</strong></label>
                            <input
                                type="text"
                                class="form-control @error('title') is-invalid @enderror"
                                id="title"
                                name="title"
                                value="{{ $nota->title }}"
                                required
                            >
                            @error('title')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <div class="grid">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="cover" class="form-label"><strong>Cover</strong></label>
                                            <input
                                                type="text"
                                                class="form-control @error('cover') is-invalid @enderror"
                                                id="cover"
                                                name="cover"
                                                value="{{ $nota->cover }}"
                                                required
                                            >
                                            @error('cover')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <div class="cover" style="background-image: url('{{ $nota->cover }}')" id="cover-preview"></div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        <div class="mb-3">
                            <label for="extract" class="form-label"><strong>Contenido, descripción breve</strong></label>
                            <textarea
                                class="form-control @error('extract') is-invalid @enderror"
                                id="extract"
                                name="extract"
                                required
                                rows="5"
                            >{{ $nota->extract }}</textarea>
                            @error('extract')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        {{-- 3. City Field --}}
                        <div class="mb-3">
                            <label for="location" class="form-label"><strong>Ciudad</strong></label>
                            <input
                                type="text"
                                class="form-control @error('location') is-invalid @enderror"
                                id="location"
                                name="location"
                                value="{{ $nota->location }}"
                                required
                            >
                            
                            </select>
                            
                        </div>

                       
                        {{-- 6. Submit Button --}}
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Guardar Nota</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('build/assets/get_link.js') }}"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyClKduTLf-pTa7JDjp0BmiGBaRyjyLydBw&libraries=places&callback=initAutocomplete"></script>

@endsection