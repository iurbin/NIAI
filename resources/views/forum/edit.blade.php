@extends('layouts.app')

@section('content')
<form method="POST" action="{{ route('forum.update', $forum) }}">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="p-3">
                    <h2>Editar entrada de Reddit</h2>
                </div>
                <div class="card-body">
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
                       
                    <div class="mb-3">
                            <label for="position" class="form-label"><strong>Position</strong></label>
                            <input
                                type="number"
                                class="form-control @error('position') is-invalid @enderror"
                                id="position"
                                name="position"
                                value="{{ $forum->position }}"
                                required
                            >
                            @error('title')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <?php
                        $default = $forum->state;
                        $options = ['subio','bajo']
                        ?>
                        <div class="mb-3">
                            <label for="state" class="form-label"><strong>Estado</strong></label>
                            <select name="state" id="state" class="form-control text-capitalize">
                                <option>Seleccionar...</option>
                                <?php foreach($options as $option): ?>
                                <option value="{{$option}}" <?=($default==$option) ? 'selected':''; ?> class="text-capitalize">{{$option}}</option>
                                <?php endforeach; ?>
                            </select>
                            
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
                    </div>
                </div>
            </div>

            <!-- STATS START -->
            <div class="col-md-4">
                <div class="card mb-3">
                    
                        <div class="card-body">
                            <h5>Agregar estadísticas a la nota</h5>
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
                @php
                $stats = $forum->stats()->where('item_type','forum_data')->get();
                
                @endphp
                <ul id="estadisticas-container" class="list-group table-stripped">
                    @foreach($stats as $stat)
                        <li class="list-group-item d-flex justify-content-between">
                            <div>
                                <h5 class="mt-2">{{ $stat->label }}</h5>
                                <p>Valor: {{ $stat->value }}<br>
                                <!-- Comparativa: {{ $stat->increase }} --></p>
                            </div>
                            <div class="text-right ">
                                <a href="javascript:void(0)" data-id="{{$stat->id}}" class="btn-delete-stat btn btn-link text-danger">Eliminar</a>
                            </div>
                            <input type="hidden" name="stat_id[]" value="{{ $stat->id }}">
                            <input type="hidden" name="stat_title[]" value="{{ $stat->label }}">
                            <input type="hidden" name="stat_value[]" value="{{ $stat->value }}">
                            <input type="hidden" name="stat_comparative[]" value="{{ $stat->increase }}">
                        </li>
                        @endforeach
                    </ul>
                    <div class="items-to-delete-container">

                    </div>
                </div>
            </div>
            <!-- STATS END -->

        </div>
    </div>
</div>
<!-- Button trigger modal -->
</form>
<script src="{{ asset('build/assets/edit-nota.js') }}"></script>


@endsection