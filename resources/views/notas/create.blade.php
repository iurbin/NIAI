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
                    <form method="POST" action="{{ route('notas.store') }}">
                        {{-- 1. CSRF Protection --}}
                        @csrf
                        <div class="mb-3 d-flex justify-content-end">
                            <div class="form-check form-switch">
                                <input class="form-check-input" name="audio_nota" value='audio_nota' type="checkbox" role="switch" id="switch_audio_nota"
                                data-bs-toggle="collapse" data-bs-target=".not_audio_nota" aria-expanded="true" aria-controls="not_audio_nota"
                                >
                                <label class="form-check-label" for="switch_audio_nota">Audio nota</label>
                            </div>
                        </div>
                        {{-- 2. Link Field --}}
                        <div class="mb-3 not_audio_nota collapse show">
                            <label for="link" class="form-label"><strong>Enlace</strong></label>
                            <input
                                type="text"
                                class="form-control @error('link') is-invalid @enderror"
                                id="link"
                                name="link"
                                value="{{ old('link') }}"
                                placeholder="Enter a URL (e.g., https://...)"
                                
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
                                value="{{ old('title') }}"
                                required
                            >
                            @error('title')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3 not_audio_nota collapse">
                            <label for="title" class="form-label"><strong>Audio URL</strong></label>
                            <input
                                type="text"
                                class="form-control @error('audio_url') is-invalid @enderror"
                                id="audio_url"
                                name="audio_url"
                                value="{{ old('audio_url') }}"
                                required
                            >
                            @error('audio_url')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3 not_audio_nota collapse show">
                            <div class="grid">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="cover" class="form-label"><strong>Cover</strong></label>
                                            <input
                                                type="text"
                                                class="form-control @error('cover') is-invalid @enderror"
                                                id="cover"
                                                name="cover"
                                                value="{{ old('cover') }}"
                                                
                                            >
                                            @error('cover')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <div class="cover" id="cover-preview"></div>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#image-upload">
                            Cargar cover
                            </button>
                        </div>
                        <div class="mb-3 not_audio_nota collapse show">
                            <label for="extract" class="form-label"><strong>Contenido, descripción breve</strong></label>
                            <textarea
                                class="form-control @error('extract') is-invalid @enderror"
                                id="extract"
                                name="extract"
                                value="{{ old('extract') }}"
                                rows="5"
                            ></textarea>
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
                                value="{{ old('location') }}"
                                required
                            >
                            
                            </select>
                            
                        </div>

                       
                        {{-- 6. Submit Button --}}
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Crear Nota</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Button trigger modal -->


<!-- Modal -->
<div class="modal fade" id="image-upload" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Cargar cover</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="max-w-md mx-auto bg-white">

        <div id="output" class="d-none text-center"></div>

        <div id="image-preview" class="d-none w-100 text-center">
            <img src="" id="uploaded-image" class="w-100 rounded border">
            <a class="btn btn-success my-2" data-bs-dismiss="modal">Usar en la nota...</a>
        </div>

        <form id="uploadForm" enctype="multipart/form-data">
            <div class="mb-4">
                <label class="block mb-2 font-bold">Seleccionar imagen:</label><br>
                <input type="file" name="image" id="imageInput" class="block w-full text-sm text-gray-500
                    file:mr-4 file:py-2 file:px-4
                    file:rounded-full file:border-0
                    file:text-sm file:font-semibold
                    file:bg-blue-50 file:text-blue-700
                    hover:file:bg-blue-100
                "/>
                <p id="error-text" class="text-red-500 text-sm mt-2 d-none"></p>
            </div>
            <div class="d-flex justify-content-between">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" id="submitBtn" class="btn btn-primary">
                    Cargar
                </button>
            </div>
        </form>
    </div>
      </div>
    </div>
  </div>
</div>
<input type="hidden" id="image_upload_url" value="{{route('image.store')}}">
<script src="{{ asset('build/assets/image-upload.js') }}"></script>
<script src="{{ asset('build/assets/get_link.js') }}"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyClKduTLf-pTa7JDjp0BmiGBaRyjyLydBw&libraries=places&callback=initAutocomplete"></script>
<script>
var imageField = document.getElementById('cover');
var coverPreview = document.getElementById('cover-preview');
imageField.addEventListener('change',function(e){
    coverPreview.style.backgroundImage = "url('"+imageField.value+"')";
})
</script>   
@endsection