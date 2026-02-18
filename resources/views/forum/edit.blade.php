@extends('layouts.app')

@section('content')

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="p-3">
                    <h2>Editar entrada de Reddit</h2>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('forum.update', $forum) }}">
                        {{-- 1. CSRF Protection --}}
                        @csrf
                        @method('PUT')

                        {{-- 2. Link Field --}}
                        <div class="mb-3">
                            <label for="link" class="form-label"><strong>Enlace</strong></label>
                            <input
                                type="text"
                                class="form-control @error('link') is-invalid @enderror"
                                id="link"
                                name="link"
                                value="{{ $forum->link }}"
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
                                value="{{ $forum->forum_title }}"
                                required
                            >
                            @error('title')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                       

                       
                        {{-- 6. Submit Button --}}
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Guardar entrada de reddit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Button trigger modal -->



@endsection