<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title></title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('description', config('app.description'))"/>
    <meta name="keywords" content="@yield('keywords', config('app.keywords'))"/>
    <meta name="copyright" content="{{ config('app.name') }}">
    <meta name="author" content="{{ config('app.name') }}"/>
    <meta name="application-name" content="@yield('title', config('app.name'))">
    
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" href="{{ asset('public/favicon.ico') }}" type="image/x-icon">
    <link rel="icon" href="{{ asset('public/favicon.ico') }}" type="image/x-icon">
    <!-- Styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('public/css/uikit.min.css') }}">
     
    @if(Auth::check())
        <link rel="stylesheet" href="{{ asset('public/css/admin.css') }}">
    @else
        <link rel="stylesheet" href="{{ asset('public/css/theme.css') }}">
    @endif 

    @yield('head')

    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
</head>
<body>

    @if(Auth::check())

        @include('includes.header-admin')  
        @include('includes.leftbar-admin')  

        <!-- CONTENT Admin -->
        <div id="content" data-uk-height-viewport="expand: true">
            <div class="uk-container uk-container-expand">
                
                @yield('content')       
                
                <footer class="uk-section uk-section-small uk-text-center">
                    <hr>
                    <p class="uk-text-small uk-text-center">Copyright 2019 - Created by ThemeSanasang </p>
                </footer>
            </div>
        </div>
        <!-- /CONTENT admin -->    
        
    @else
        <!-- content Other -->
        @yield('content') 
        <!-- /content Other -->      
    @endif 
    
    
    <!-- Scripts -->
    <script src="{{ asset('public/js/uikit.min.js') }}"></script>
    <script src="{{ asset('public/js/uikit-icons.min.js') }}"></script>
   
    @yield('script-footer') 
    
</body>
</html>
