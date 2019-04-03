@extends('layouts.app')

@section('content')

<h3>เพิ่มผู้ใช้งาน</h3>
<hr>

{!! Form::open( array('route' => 'users.store', 'class' => 'uk-form-horizontal uk-margin-small uk-grid') ) !!}
    <div class="uk-width-1-2@m">
        <div class="uk-margin">
            <label class="uk-form-label" for="username">ชื่อผู้ใช้งาน <span class="uk-text-danger">*</span></label>
            <div class="uk-form-controls">
                <input class="uk-input {{ $errors->has('username') ? ' uk-form-danger' : '' }}" id="username" type="text" name="username" value="{{ old('username') }}" placeholder="ชื่อผู้ใช้งาน" required autofocus>
                @if ($errors->has('username'))
                    <div class="uk-text-danger">
                        {{ $errors->first('username') }}
                    </div>
                @endif
            </div>
        </div>

        <div class="uk-margin">
            <label class="uk-form-label" for="password">รหัสผ่าน <span class="uk-text-danger">*</span></label>
            <div class="uk-form-controls">
                <input class="uk-input {{ $errors->has('password') ? ' uk-form-danger' : '' }}" id="password" type="password" name="password" placeholder="รหัสผ่าน" required>
                @if ($errors->has('password'))
                    <div class="uk-text-danger">
                        {{ $errors->first('password') }}
                    </div>
                @endif
            </div>
        </div>

        <div class="uk-margin">
            <label class="uk-form-label" for="password_confirmation">ยืนยันรหัสผ่าน <span class="uk-text-danger">*</span></label>
            <div class="uk-form-controls">
                <input class="uk-input {{ $errors->has('password') ? ' uk-form-danger' : '' }}" id="password_confirmation" type="password" name="password_confirmation" placeholder="ยืนยันรหัสผ่าน" required>
            </div>
        </div>

        <div class="uk-margin">
            <label class="uk-form-label" for="fullname">ชื่อ-นามสกุล <span class="uk-text-danger">*</span></label>
            <div class="uk-form-controls">
                <input class="uk-input {{ $errors->has('fullname') ? ' uk-form-danger' : '' }}" id="fullname" type="text" name="fullname" placeholder="ชื่อ-นามสกุล" required>
                @if ($errors->has('fullname'))
                    <div class="uk-text-danger">
                        {{ $errors->first('fullname') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <div class="uk-width-1-2@m">
        <div class="uk-margin">
            <label class="uk-form-label" for="email">อีเมล์</label>
            <div class="uk-form-controls">
                <input class="uk-input" id="email" type="text" name="email" placeholder="อีเมล์">
            </div>
        </div>

        <div class="uk-margin">
            <label class="uk-form-label" for="level">ระดับการใช้งาน</label>
            <div class="uk-form-controls">
                {!! Form::select('level', $level, null, ['class'=> 'uk-select', 'id' => 'level']) !!}
            </div>
        </div>

        <div class="uk-margin">
            <label class="uk-form-label" for="status">สถานะการใช้งาน</label>
            <div class="uk-form-controls">
                {!! Form::select('status', $status, null, ['class'=> 'uk-select', 'id' => 'status']) !!}
            </div>
        </div>
    </div>

    <div class="uk-margin-medium-top uk-width-1-1@m">
        <div class="uk-text-center">
            <button type="submit" class="uk-button uk-button-primary">บันทึก</button>
        </div>
    </div>
{!! Form::close() !!}<!-- form -->

<a class="uk-button uk-button-default" href="{{ url('users') }}"><span uk-icon="icon: arrow-left"></span> ย้อนกลับ</a>

@endsection