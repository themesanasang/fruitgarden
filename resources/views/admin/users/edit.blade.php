@extends('layouts.app')

@section('content')
<h3>แก้ไขข้อมูล ผู้ใช้งาน</h3>
<hr>

{!! Form::open( array('route' => ['users.update', Crypt::encryptString($user['id'])], 'class' => 'uk-form-horizontal uk-margin-small uk-grid', 'method' => 'PATCH') ) !!}
    <div class="uk-width-1-2@m">
        <div class="uk-margin">
            <label class="uk-form-label" for="username">ชื่อผู้ใช้งาน</label>
            <div class="uk-form-controls">
                <input class="uk-input" id="username" type="text" name="username" value="{{ $user->username }}" disabled>
            </div>
        </div>

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

        <div class="uk-margin">
            <label class="uk-form-label" for="fullname">ชื่อ-นามสกุล</label>
            <div class="uk-form-controls">
                <input class="uk-input" id="fullname" type="text" name="fullname" value="{{ $user->fullname }}" disabled>
            </div>
        </div>
    </div>
    
    <div class="uk-width-1-2@m">
        <div class="uk-margin">
            <label class="uk-form-label" for="email">อีเมล์</label>
            <div class="uk-form-controls">
                <input class="uk-input" id="email" type="text" name="email" value="{{ $user->email }}" placeholder="อีเมล์">
            </div>
        </div>

        <div class="uk-margin">
            <label class="uk-form-label" for="level">ระดับการใช้งาน</label>
            <div class="uk-form-controls">
                {!! Form::select('level', $level, $user->level, ['class'=> 'uk-select', 'id' => 'level']) !!}
            </div>
        </div>

        <div class="uk-margin">
            <label class="uk-form-label" for="status">สถานะการใช้งาน</label>
            <div class="uk-form-controls">
                {!! Form::select('status', $status,  $user->status, ['class'=> 'uk-select', 'id' => 'status']) !!}
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