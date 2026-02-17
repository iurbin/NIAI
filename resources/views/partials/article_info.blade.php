<div class="row text-center d-flex justify-content-center counters">
                        
    <div class="col-md-3 mb-4 kpi-item">
        <div class="glass-card text-white">
            <div class="glasscard-bg nota-item d-flex align-items-center" style="background-image:url('{{ $nota->cover }}');">
                <div class="glass-card-content">
                    <h5 class="clash-bold text-center mt-2 mb-0">{{ Illuminate\Support\Str::limit($nota->title, 55) }}</h5>
                    <small class="clash">{{ $nota->location }}</small>
                    <br>
                    <br>
                    <a class="btn btn-secondary btn-small btn-clash-rounded btn-article-info" data-id="{{$nota->id}}" href="{{ route('article_info') }}">Ver más</a>
                </div>
            </div>
        </div>
    </div>
    
    @forelse($nota->stats as $stat)
    <div class="col-md-3 mb-4 kpi-item">
        <div class="glass-card text-white">
            <div class="glasscard-bg">
                <img src="{{asset('build/assets/images/icons/goals.svg')}}" class="info-card-icon" />
                <h5 class="clash text-center mt-2">{{ $stat->label }}</h5>
                <div class="stat-value">
                    <span>{{$stat->value}}</span>
                    <!-- <span class="stat-small text-success-custom"><i class="fas fa-arrow-up"></i> <span class="counter" data-count="50">0</span>%</span> -->
                </div>
            </div>
        </div>
    </div>
    @empty
        No hay estadísticas para esta nota.
    @endforelse
    
    
    
</div>