@extends('layouts.app')

@section('content')
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
        <div>
            <div class="uk-text-center">
                <a class="uk-link-reset uk-text-small" data-uk-toggle="target: #recover;animation: uk-animation-slide-top-small">ลืมรหัสผ่าน?</a>
            </div>
            <div class="uk-margin-small-top" id="recover" hidden>
                <form action="login.html">
                    
                    <div class="uk-margin-small">
                        <div class="uk-inline uk-width-1-1">
                            <span class="uk-form-icon uk-form-icon-flip" data-uk-icon="icon: mail"></span>
                            <input class="uk-input" placeholder="อีเมล์" required type="text">
                        </div>
                    </div>
                    <div class="uk-margin-small">
                        <button type="submit" class="uk-button uk-button-primary uk-width-1-1">ส่งรหัสผ่าน</button>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
