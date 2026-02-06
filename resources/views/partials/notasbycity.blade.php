@forelse($notas as $nota)
<div class="col-md-3 mb-4 kpi-item " data-aos="zoom-in" data-aos-delay="400">
    <div class="glass-card h-100 text-white">
        <div class="glasscard-bg nota-item d-flex align-items-center" style="background-image:url('{{$nota->cover}}');">
            <div class="glass-card-content">
                <h5 class="clash-bold text-center mt-2 mb-0">{{ $nota->title }}</h5>
                <small class="clash">{{ $nota->title }}</small>
                <br>
                <br>
                <a class="btn btn-secondary btn-small btn-clash-rounded" href="{{ $nota->link }}" target="_blank">Ver nota</a>
            </div>
        </div>
    </div>
</div>
@empty
<h3>No se encontraron notas en esta ciudad.</h3>
@endforelse