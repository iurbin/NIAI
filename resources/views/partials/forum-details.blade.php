<h5 class="text-white clash">{{ Illuminate\Support\Str::limit($foro->forum_title,45) }}</h5>
<div class="row counters">
    @forelse($stats as $stat)
    <div class="col-6 p-3 kpi-item">
        <div class="glass-card h-100 text-white animate__animated animate__bounceIn">
            <div class="glasscard-bg text-center">
                @if($stat->label == 'Comentarios')
                <img src="{{asset('build/assets/images/icons/comments.svg')}}" class="info-card-icon" />
                @else
                <img src="{{asset('build/assets/images/icons/user-views.svg')}}" class="info-card-icon" />
                @endif
                <h5 class="clash text-center mt-2">{{ $stat->label }}</h5>
                <div class="stat-value">
                    <span class="counter">{{$stat->value}}</span>
                    <!-- <span class="stat-small text-success-custom"><i class="fas fa-arrow-up"></i> <span class="counter" data-count="50">0</span>%</span> -->
                </div>
            </div>
        </div>
    </div>
    
    @empty 
    <div class="alert text-white">
        No hay datos para este foro
    </div>
    @endforelse
</div>