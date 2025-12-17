<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link href="{{asset('build/assets/front/bootstrap-icons.css')}}" rel="stylesheet">
    <link href="{{asset('build/assets/nia-front.css')}}" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app-front.scss', 'resources/js/app.js'])
</head>
<body>
    <div id="app">
        
        <div class="nav-menu">
                    <button class="btn btn-dark burger-button" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu">
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
                        
                        <div class="custom-search-menu">
                            <i class="bi bi-search"></i>
                            <input type="text" placeholder="Menú"> 
                        </div>

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
                            Reddit
                            </a>
                        </li>
                        </ul>
                    </div>
                    </div>
                
        </div>
        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
