@extends('layouts.front')

@section('content')
<!-- map items -->
<link rel="stylesheet" href="{{asset('build/assets/map/map.css')}}" type="text/css">
<script src="{{asset('build/assets/map/d3.v7.min.js')}}"></script>
<script src="{{asset('build/assets/map/topojson-client.min.js')}}"></script>
<!-- map items -->



<link href="{{asset('build/assets/css/aos.css')}}" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <section id="intro" class="text-center bg-gradient-dark">
        <div class="container">
            <div class="title-glow-container">
                <h1 class="clash text-white" data-aos="fade-up" data-aos-delay="500">Países</h1>
                <h2 class="clash text-white" data-aos="fade-up" data-aos-delay="400">Mapa General</h2>
                <div class="title-glow" data-aos="fade" data-aos-delay="100"></div>
            </div>
            <div class="world-container" data-aos="fade-up" data-aos-delay="800">
                <div id="globe-container"></div>
            </div>
            <script>
                const dataUrl = "{{asset('build/assets/map/countries-110m.json')}}";
                patternBackground = "{{asset('build/assets/map/country-fill.png')}}";
            </script>
            <script src="{{asset('build/assets/map/map-mainv2.js')}}"></script>
        </div>
    </section>
    <section id="kpis" class="bg-gradient-dark">
        <div class="container">
            <div class="title-glow-container">
                <h1 class="text-center clash mt-5 text-white" data-aos="fade-up" data-aos-delay="200">KPIs</h1>
                <div class="title-glow" data-aos="fade" data-aos-delay="100"></div>
            </div>
            <div class="text-center pb-5">
                    
                    <ul class="nav d-flex justify-content-center kpi-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation" data-aos="fade" data-aos-delay="200">
                            <button class="btn btn-outline-light btn-lg btn-clash-rounded active" id="home-tab" data-bs-toggle="tab" data-bs-target="#generales-tab" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">Generales</button>
                        </li>
                        <li class="nav-item" role="presentation" data-aos="fade" data-aos-delay="300">
                            <button class="btn btn-outline-light btn-lg btn-clash-rounded" id="profile-tab" data-bs-toggle="tab" data-bs-target="#individuales-tab" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">Individuales</button>
                        </li>
                    </ul>
                </div>

            {{-- Generales --}}
            <div class="tab-content">
                <div id="generales-tab" class="tab-pane fade show active" role="tabpanel">
                    <div class="row text-center d-flex justify-content-center counters">
                        
                        <div class="col-md-3 mb-4 kpi-item" data-aos="zoom-in" data-aos-delay="0">
                            <div class="glass-card h-100 text-white">
                                <div class="glasscard-bg">
                                    <img src="{{asset('build/assets/images/icons/notas-check.svg')}}" class="info-card-icon" />
                                    <h5 class="clash text-center mt-2">Notas globales</h5>
                                    <div class="stat-value">
                                        <span class="counter" data-count="{{ $total_notas }}">0</span>
                                        <span class="stat-small text-success-custom"><i class="fas fa-arrow-up"></i> <span class="counter" data-count="10">0</span>%</span>
                                    </div>
                                    <!-- Find Percentage Increase/Decrease -->
                                    <!-- ((change number / current number) * 100) - 100 -->
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-3 mb-4 kpi-item" data-aos="zoom-in" data-aos-delay="200">
                            <div class="glass-card h-100 text-white">
                                <div class="glasscard-bg">
                                    <img src="{{asset('build/assets/images/icons/user-views.svg')}}" class="info-card-icon" />
                                    <h5 class="clash text-center mt-2">Visitas totales</h5>
                                    <div class="stat-value">
                                        <span class="counter" data-count="50">0</span>
                                        <span class="stat-small text-success-custom"><i class="fas fa-arrow-up"></i> <span class="counter" data-count="50">0</span>%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
        
                        <div class="col-md-3 mb-4 kpi-item" data-aos="zoom-in" data-aos-delay="300">
                            <div class="glass-card h-100 text-white">
                                <div class="glasscard-bg">
                                    <img src="{{asset('build/assets/images/icons/goals.svg')}}" class="info-card-icon" />
                                    <h5 class="clash text-center mt-2">Alcance total</h5>
                                    <div class="stat-value">
                                        <span class="counter" data-count="20">0</span>
                                        <span class="stat-small text-success-custom"><i class="fas fa-arrow-up"></i> <span class="counter" data-count="60">0</span>%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        
                    </div>
                </div>
                
                <div id="individuales-tab" class="tab-pane fade" role="tabpanel">
                    <div id="kpi-news" class="carousel slide">
                        <div class="carousel-inner">
                            @php $i = 0 ; $firstclass = ''; @endphp
                            
                            @foreach($notas as $nota)
                                @php if($i == 0 ): $firstclass = 'active'; else: $firstclass = ''; endif;  @endphp
                                
                                @if ($i % 3 === 0) 
                                    @if ($i !== 0 )
                                        </div>
                                        </div>
                                        
                                    @endif
                                    <div class="carousel-item {{$firstclass}}"> 
                                        <div class="row text-center d-flex justify-content-center">
                                    
                                @endif
                                            <div class="col-md-3 mb-4 kpi-item " data-aos="zoom-in" data-aos-delay="400">
                                                <div class="glass-card h-100 text-white">
                                                    <div class="glasscard-bg nota-item d-flex align-items-center" style="background-image:url('{{ $nota->cover }}');">
                                                        <div class="glass-card-content">
                                                            <h5 class="clash-bold text-center mt-2 mb-0">{{ Illuminate\Support\Str::limit($nota->title, 55) }}</h5>
                                                            <small class="clash">{{ $nota->location }}</small>
                                                            <br>
                                                            <br>
                                                            <a class="btn btn-secondary btn-small btn-clash-rounded" href="javascript:void(0)">Ver KPIs</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                
                                @php $i++ @endphp
                                @endforeach

                                @if ($i % 3 !== 0) 
                                        </div><!-- row -->
                                    </div><!-- carousel item -->
                                @else
                                </div>
                                @endif
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#kpi-news" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#kpi-news" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                </div>
            </div>
        </div>
        
    </section>

    
    <section id="reddit">
        <div class="container">
            <div class="title-glow-container mt-5 text-center">
                <h1 class="clash text-white" data-aos="fade-up" data-aos-delay="500">Reporte</h1>
                <h2 class="clash text-white" data-aos="fade-up" data-aos-delay="400">Reddit</h2>
                <div class="title-glow" data-aos="fade" data-aos-delay="100"></div>
            </div>
            <div class="content">
                <div class="row">
                    <div class="col-md-5">
                        <h5 class="text-white clash">Lorem ipsum dolor sit ammet</h5>
                        <div class="row counters">
                            <div class="col-6 p-3 kpi-item">
                                <div class="glass-card h-100 text-white" data-aos="zoom-in" data-aos-delay="100">
                                    <div class="glasscard-bg text-center">
                                        <img src="{{asset('build/assets/images/icons/comments.svg')}}" class="info-card-icon" />
                                        <h5 class="clash text-center mt-2">Comentarios</h5>
                                        <div class="stat-value">
                                            <span class="counter" data-count="50">0</span>
                                            <span class="stat-small text-success-custom"><i class="fas fa-arrow-up"></i> <span class="counter" data-count="50">0</span>%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 p-3 kpi-item">
                                <div class="glass-card h-100 text-white" data-aos="zoom-in" data-aos-delay="300">
                                    <div class="glasscard-bg text-center">
                                        <img src="{{asset('build/assets/images/icons/forums.svg')}}" class="info-card-icon" />
                                        <h5 class="clash text-center mt-2">Foros atendidos</h5>
                                        <div class="stat-value">
                                            <span class="counter" data-count="50">0</span>
                                            <span class="stat-small text-success-custom"><i class="fas fa-arrow-up"></i> <span class="counter" data-count="50">0</span>%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="table-heading-container pb-2 mb-3" data-aos="zoom-in" style="border-bottom: 2px solid white;">
                            <h4 class="clash text-white">Más</h4>
                        </div>
                        <div class="table-container">
                        <table class="table table-dark table-hover mb-0 nia-table">
                            <thead>
                                <tr data-aos="zoom-in" data-aos-delay="100">
                                    <th></th>
                                    <th>Foro</th>
                                    <th>Top</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr data-aos="zoom-in" data-aos-delay="200">
                                    <td><i class="fab fa-reddit fa-2x text-white v-middle"></i> Reddit</td>
                                    <td>
                                        <a href="#" class="btn btn-secondary btn-clash-rounded">Lorem ipsum dolor sit...</a>
                                        <a href="#" class="btn btn-secondary btn-clash-rounded">
                                            <i class="bi bi-arrow-up-right-circle"></i>
                                        </a>
                                    </td>
                                    <td><i class="bi bi-arrow-down-right text-danger"></i> 1</td>
                                </tr>
                                <tr data-aos="zoom-in" data-aos-delay="300">
                                    <td><i class="fab fa-reddit fa-2x text-white v-middle"></i> Reddit</td>
                                    <td>
                                        <a href="#" class="btn btn-secondary btn-clash-rounded">Lorem ipsum dolor sit...</a>
                                        <a href="#" class="btn btn-secondary btn-clash-rounded">
                                            <i class="bi bi-arrow-up-right-circle"></i>
                                        </a>
                                    </td>
                                    <td><i class="bi bi-arrow-up-right text-success"></i> 2</td>
                                </tr>
                                <tr data-aos="zoom-in" data-aos-delay="400">
                                    <td><i class="fab fa-reddit fa-2x text-white v-middle"></i> Reddit</td>
                                    <td>
                                        <a href="#" class="btn btn-secondary btn-clash-rounded">Lorem ipsum dolor sit...</a>
                                        <a href="#" class="btn btn-secondary btn-clash-rounded">
                                            <i class="bi bi-arrow-up-right-circle"></i>
                                        </a>
                                    </td>
                                    <td><i class="bi bi-arrow-up-right text-success"></i> 2</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    </div>
                </div>
            </div>
            </div>
        </div>
    </section>

    <section id="noticias">
        <div class="container">
            
                <div class="title-glow-container text-center">
                    <h1 class="clash mt-5 text-white" data-aos="fade-up" data-aos-delay="300">Noticias</h1>
                    <div class="title-glow" data-aos="fade" data-aos-delay="100"></div>
                </div>
            


                <div class="news-container pt-5">
                    <div class="noticias">
                        <div class="row text-center d-flex justify-content-center counters">
                            <div id="carouselNews" class="carousel slide">
                                <div class="carousel-inner">
                                    @php $i = 0 ; $firstclass = ''; @endphp
                                    
                                    @foreach($notas as $nota)
                                        @php if($i == 0 ): $firstclass = 'active'; else: $firstclass = ''; endif;  @endphp
                                        
                                        @if ($i % 3 === 0) 
                                            @if ($i !== 0 )
                                                </div>
                                                </div>
                                                
                                            @endif
                                            <div class="carousel-item {{$firstclass}}"> 
                                                <div class="row text-center d-flex justify-content-center">
                                            
                                        @endif
                                                    <div class="col-md-3 mb-4 kpi-item " data-aos="zoom-in" data-aos-delay="400">
                                                        <div class="glass-card h-100 text-white">
                                                            <div class="glasscard-bg nota-item d-flex align-items-center" style="background-image:url('{{ $nota->cover }}');">
                                                                <div class="glass-card-content">
                                                                    <h5 class="clash-bold text-center mt-2 mb-0">{{ Illuminate\Support\Str::limit($nota->title, 55) }}</h5>
                                                                    <small class="clash">{{ $nota->location }}</small>
                                                                    <br>
                                                                    <br>
                                                                    <a class="btn btn-secondary btn-small btn-clash-rounded" href="{{ $nota->link }}" target="_blank">Ver más</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                        
                                        @php $i++ @endphp
                                        @endforeach

                                        @if ($i % 3 !== 0) 
                                                </div><!-- row -->
                                            </div><!-- carousel item -->
                                        @else
                                        </div>
                                        @endif
                                    </div>
                                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselNews" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Previous</span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-bs-target="#carouselNews" data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Next</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
                        

        </div>
        
        
        
    </section>



    <div class="modal fade" id="city_news" aria-hidden="true" aria-labelledby="" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content transparent text-white">
                    <h2 class="text-center my-2">Publicaciones desde <div class="location-feed">cargardo...</div></h2>
                    <div class="container">
                        <div class="row justify-content-center news-container">
                            
                        </div>
                    </div>
            </div>
        </div>
    </div>
    
    <script src="{{asset('build/assets/js/counter2.js')}}"></script>
    <script src="{{asset('build/assets/js/aos.js')}}"></script>
    <!-- <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>  -->
     
    <script>
        
        // Initialize Animations
        AOS.init({
            duration: 1000,
            once: false,
            mirror: true
        });
    </script>
@endsection
