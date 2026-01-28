{{-- Assumes you have a layout file: resources/views/layouts/app.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2>Foros de Reddit <i class="fab fa-reddit fa-2x text-white v-middle"></i></h2>
                <a href="{{ route('notas.create') }}" class="btn btn-primary">
                    Agregar nueva
                </a>
            </div>

            {{-- 2. Forum Table --}}
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">#ID</th>
                                    <th scope="col">Titulo</th>
                                    <th scope="col">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                @forelse ($items as $item)
                                    <tr>
                                        <th scope="row">{{ $item->id }}</th>
                                        <td>{{ $item->title }}</td>
                                        
                                        <td>
                                            {{-- Action Buttons --}}
                                            <a href="{{ $item->link }}" target="_blank" class="btn btn-info btn-sm">Ver</a>
                                            <a href="{{ route('forum.edit', $item) }}" class="btn btn-warning btn-sm">Editar</a>
                                            {{-- Delete Button (needs a form) --}}
                                            <form action="{{ route('forum.destroy', $item) }}" method="POST" class="d-inline"
                                                  onsubmit="return confirm('Esta segur@ de eliminar este item?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">
                                            No se encontraron Publicaciones.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- 3. Pagination Links --}}
            <div class="d-flex justify-content-center mt-4">
                {{-- This renders the pagination links and respects the Bootstrap setting from AppServiceProvider --}}
                {!! $items->links() !!}
            </div>

        </div>
    </div>
</div>



@endsection