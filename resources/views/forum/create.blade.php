@extends('layouts.app')

@section('content')

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="p-3">
                    <h2>Agregar nueva entrada de Reddit</h2>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('forum.store') }}">
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
                                value="{{ old('link') }}"
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
                            <label for="forum_title" class="form-label"><strong>Título</strong></label>
                            <input
                                type="text"
                                class="form-control @error('forum_title') is-invalid @enderror"
                                id="forum_title"
                                name="forum_title"
                                value="{{ old('forum_title') }}"
                                required
                            >
                            @error('title')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="position" class="form-label"><strong>Position</strong></label>
                            <input
                                type="number"
                                class="form-control @error('position') is-invalid @enderror"
                                id="position"
                                name="position"
                                value="{{ old('position') }}"
                                required
                            >
                            @error('title')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="state" class="form-label"><strong>Estado</strong></label>
                            <select name="state" id="state" class="form-control">
                                <option>Seleccionar...</option>
                                <option value="subio">Subio</option>
                                <option value="bajo">Bajo</option>
                            </select>
                            
                            @error('title')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                       

                       
                        {{-- 6. Submit Button --}}
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Crear entrada de reddit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

         <!-- STATS START -->
            <div class="col-md-4">
            <div class="card mb-3">
                
                    <div class="card-body">
                        <h5>Agregar estadísticas</h5>
                        <div class="form-block mb-3">
                            <label for="">Título</label>
                            <input type="text" class="form-control" name="stat_title" id="stat_title">
                        </div>
                        <div class="form-block mb-3">
                            <label for="">Valor</label>
                            <input type="number" class="form-control" name="stat_value" id="stat_value">
                        </div>
                        <!-- <div class="form-block mb-3">
                            <label for="">Comparativa (%)</label>
                            <input type="number" class="form-control" name="stat_comparative" id="stat_comparative">
                        </div> -->
                        <div class="form-block mb-3">
                            <a href="javascript:void(0)" id="btn-add-stat" class="btn btn-primary">Agregar</a>
                        </div>
                    </div>
                
            </div>

            <div class="card">
                <ul id="estadisticas-container" class="list-group table-stripped">
                
                </ul>
                <div class="items-to-delete-container">

                </div>
            </div>
            <!-- STATS END -->
    </div>
</div>
<!-- Button trigger modal -->


<script src="{{ asset('build/assets/edit-nota.js') }}"></script>
@endsection