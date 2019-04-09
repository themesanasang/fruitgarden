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
     
    <link rel="stylesheet" href="{{ asset('public/css/theme.css') }}">

    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
</head>
<body>

<div class="uk-height-1-1">
<div class="uk-flex uk-flex-center uk-flex-middle uk-background-default uk-height-viewport">
    <div class="uk-position-bottom-center uk-position-small uk-visible@m">
        <span class="uk-text-small uk-text-muted">© 2019 - <a href="#">Created by Themesanasang</a></span>
    </div>
    <div class="uk-width-medium uk-padding-small uk-box-shadow-small">
        <form method="POST" action="{{ route('login') }}">
        @csrf
            <fieldset class="uk-fieldset">
                <legend class="uk-legend">ระบบจัดการ</legend>
                <div class="uk-margin">
                    <div class="uk-inline uk-width-1-1">
                        <span class="uk-form-icon uk-form-icon-flip" data-uk-icon="icon: user"></span>
                        <input class="uk-input uk-form-large" required placeholder="ชื่อผู้ใช้งาน" type="text" name="username" value="{{ old('username') }}" autofocus>
                    </div>
                </div>
                <div class="uk-margin">
                    <div class="uk-inline uk-width-1-1">
                        <span class="uk-form-icon uk-form-icon-flip" data-uk-icon="icon: lock"></span>
                        <input class="uk-input uk-form-large" required placeholder="รหัสผ่าน" type="password" name="password">
                    </div>
                </div>
                
                <div class="uk-margin">
                    <label><input class="uk-checkbox" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}> จดจำการเข้าสู่ระบบ</label>
                </div>

                @if(Session::has('error_login'))		
                <div class="uk-alert-danger" uk-alert>
                    <a class="uk-alert-close" uk-close></a>
                    <p>{{ Session('error_login') }}</p>
                </div>
                @endif

                <div class="uk-margin">
                    <button type="submit" class="uk-button uk-button-primary uk-button-large uk-width-1-1">เข้าสู่ระบบ</button>
                </div>
            </fieldset>
        </form>
    </div>
</div>
</div>

<!-- Scripts -->
<script src="{{ asset('public/js/uikit.min.js') }}"></script>
<script src="{{ asset('public/js/uikit-icons.min.js') }}"></script>
    
</body>
</html>
