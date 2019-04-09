@extends('layouts.app')

@section('content')
<h3>แก้ไขรหัสผ่าน</h3>

<form class="uk-form-horizontal uk-margin-small uk-grid" method="POST" action="{{ url('password/reset') }}">
    {{ csrf_field() }}
    <div class="uk-width-1-1@m">
    <div class="uk-margin">
            <label class="uk-form-label" for="password">รหัสผ่าน</label>
            <div class="uk-form-controls">
                <input class="uk-input {{ $errors->has('password') ? ' uk-form-danger' : '' }}" id="password" type="password" name="password" placeholder="รหัสผ่าน">
                @if ($errors->has('password'))
                    <div class="uk-text-danger">
                        {{ $errors->first('password') }}
                    </div>
                @endif
            </div>
    </div>
    <div class="uk-margin">
        <label class="uk-form-label" for="password_confirmation">ยืนยันรหัสผ่าน</label>
        <div class="uk-form-controls">
            <input class="uk-input {{ $errors->has('password') ? ' uk-form-danger' : '' }}" id="password_confirmation" type="password" name="password_confirmation" placeholder="ยืนยันรหัสผ่าน">
        </div>
    </div>
    </div>

    <div class="uk-margin-medium-top uk-width-1-1@m">
        <div class="uk-text-center">
            <button type="submit" class="uk-button uk-button-primary">บันทึก</button>
            @if ($errors->has('success'))
                <div class="uk-margin-small-top uk-text-success">
                    {{ $errors->first('success') }}
                </div>
            @endif
        </div>
    </div>
</form>
@endsection