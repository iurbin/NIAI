@forelse($notas as $nota)
<div class="col-md-6 mb-4 kpi-item " data-aos="zoom-in" data-aos-delay="200">
    <div class="card mb-3 custom-card" style="border:0 none;">
        <div class="row g-0">
            <div class="col-md-4 h-100 nota-cover" style="background-image: url('{{$nota->cover}}')">
                
            </div>
            <div class="col-md-8 offset-md-4">
                <div class="card-body">
                    <h5 class="card-title">{{ Illuminate\Support\Str::limit($nota->title, 55) }}</h5>
                    
                    <p class="card-text"><small class="">{{ $nota->location }}</small></p>
                    <div class="d-flex justify-content-end">
                        <a class="btn btn-primary btn-small btn-clash-rounded" href="{{ $nota->link }}" target="_blank">Ver nota</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@empty
<h3>No se encontraron notas en esta ciudad.</h3>
@endforelse