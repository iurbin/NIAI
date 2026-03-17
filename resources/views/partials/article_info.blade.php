<div class="">
    <h3 class="clash-bold mt-2 mb-0">{{ $nota->title }}</h3>
    <p>
        {{$nota->extract}}<br>

        <small class="clash">{{ $nota->location }}</small><br>
        <div class="d-flex justify-content-between">
            @if($nota->link!='')
            <a class="btn btn-secondary btn-small btn-clash-rounded mt-3" href="{{ $nota->link }}" target="_blanks">Ver más</a>
            @endif
            <a class="btn btn-outline-light btn-clash-rounded btn mt-3" data-bs-dismiss="modal">Close</a>
        </div>
    </p>
</div>
<div class="row text-center d-flex justify-content-center counters">
    @if($nota->link!='')            
    <div class="col-md-6 mb-4 kpi-item">
        <div class="glass-card text-white">
            <img class="article-info-cover" src="{{ $nota->cover }}" />
        </div>
        
    </div>
    @endif
    @if($nota->audio_url!='')
        <audio controls>
            <source src="{{ asset('storage/sounds/' . $nota->audio_url) }}" type="audio/mpeg">
            Your browser does not support the audio element.
        </audio>
    @endif
    <?php 
    $stats = $nota->stats()->where('item_type','nota_data')->get();
    ?>
    <div class="col-md-6 mb-4 kpi-item">
        
        
        <div class="row">
            @forelse($stats as $stat)
                <div class="col-6 text-center">
                    <div class="glass-card text-white">
                        <div class="glasscard-bg">
                            <img src="{{asset('build/assets/images/icons/goals.svg')}}" class="info-card-icon" />
                            <h5 class="clash text-center mt-2">{{ $stat->label }}</h5>
                            <div class="stat-value">
                                <!-- <span><?php /* echo ($stat->value > 1000) ? number_format($stat->value / 1000,0) . 'k':$stat->value; */ ?></span> -->
                                <span>{{ Number::abbreviate($stat->value) }}</span>
                                <!-- <span class="stat-small text-success-custom"><i class="fas fa-arrow-up"></i> <span class="counter" data-count="50">0</span>%</span> -->
                            </div>
                        </div>
                    </div>
                </div>
            @empty
            <div class="p-4">
                No hay estadísticas para esta nota.
            </div>
            @endforelse
    </div>
    </div>
    
    
    
</div>