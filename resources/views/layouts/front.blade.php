<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    
    <link href="{{asset('build/assets/front/fonts/clash/clash.css')}}" rel="stylesheet">
    <link href="{{asset('build/assets/front/bootstrap-icons.css')}}" rel="stylesheet">
    <link href="{{asset('build/assets/nia-front.css')}}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</head>
<body>
    <div id="app">
        
        <div class="nav-menu">
                    <button class="burger-button" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu">
                        <i class="bi bi-list"></i>
                    </button>

                    <div class="offcanvas offcanvas-end" tabindex="-1" id="sidebarMenu" aria-labelledby="sidebarMenuLabel">
                    
                    <div class="offcanvas-header">
                        <div class="d-flex flex-column">
                            <h5 class="offcanvas-title" id="sidebarMenuLabel">Dashboard</h5>
                            <p>Welcome!</p> 
                        </div>
                        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    
                    <div class="offcanvas-body">
                        
                        {{-- <div class="custom-search-menu">
                            <i class="bi bi-search"></i>
                            <input type="text" placeholder="Menú"> 
                        </div> --}}

                        <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                            Mapa 
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                            KPIs
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                            Reddit
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                            Noticias
                            </a>
                        </li>
                        </ul>
                    </div>
                    </div>
                
        </div>
        <main class="">
            @yield('content')
        </main>
    </div>
</body>
</html>
