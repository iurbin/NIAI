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
                            <button type="button" class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#image-upload">
                            Cargar cover
                            </button>
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

        <div class="col-md-4">
            <div class="card mb-3">
                <form method="POST" action="{{ route('notas.update', $nota) }}">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <h5>Agregar estadisticas a la nota</h5>
                        <div class="form-block mb-3">
                            <label for="">Titulo</label>
                            <input type="text" class="form-control" name="stat_title">
                        </div>
                        <div class="form-block mb-3">
                            <label for="">Valor</label>
                            <input type="number" class="form-control" name="stat_value">
                        </div>
                        <div class="form-block mb-3">
                            <label for="">Comparativa</label>
                            <input type="number" class="form-control" name="stat_comparative">
                        </div>
                        <div class="form-block mb-3">
                            <button type="submit" class="btn btn-primary">Agregar</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="card">
                <ul class="list-group table-stripped">
                    <li class="list-group-item d-flex justify-content-between">
                        <div>
                            <h5 class="mt-2">Visitas</h5>
                            <p>Valor: 30<br>
                            Comparativa: 10%</p>
                        </div>
                        <div class="text-right ">
                            <a href="javascript:void(0)" class="btn-delete-stat btn btn-link text-danger">Eliminar</a>
                        </div>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <div>
                            <h5 class="mt-2">Alcance</h5>
                            <p>Valor: 25<br>
                            Comparativa: 15%</p>
                        </div>
                        <div class="text-right ">
                            <a href="javascript:void(0)" class="btn-delete-stat btn btn-link text-danger">Eliminar</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

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
<script src="{{ asset('build/assets/edit-nota.js') }}"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyClKduTLf-pTa7JDjp0BmiGBaRyjyLydBw&libraries=places&callback=initAutocomplete"></script>
<script>
var imageField = document.getElementById('cover');
var coverPreview = document.getElementById('cover-preview');
imageField.addEventListener('change',function(e){
    coverPreview.style.backgroundImage = "url('"+imageField.value+"')";
})
</script>
@endsection