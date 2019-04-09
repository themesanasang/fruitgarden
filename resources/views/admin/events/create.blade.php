@extends('layouts.app')

@section('content')

<h3>เพิ่ม กิจกรรม</h3>
<hr>

{!! Form::open( array('route' => 'events.store', 'enctype' => 'multipart/form-data', 'class' => 'uk-form-horizontal uk-margin-small uk-grid') ) !!}
    <div class="uk-width-1-1@m">
        <div class="uk-margin">
            <label class="uk-form-label" for="name">สวนผลไม้ <span class="uk-text-danger">*</span></label>
            <div class="uk-form-controls">
                {!! Form::select('garden_id', $garden, null, ['class'=> 'uk-select', 'id' => 'garden_id']) !!}   
            </div>
        </div>
        <div class="uk-margin">
            <label class="uk-form-label" for="name">ชื่อกิจกรรม <span class="uk-text-danger">*</span></label>
            <div class="uk-form-controls">
                <input class="uk-input {{ $errors->has('name') ? ' uk-form-danger' : '' }}" id="name" type="text" name="name" value="{{ old('name') }}" placeholder="ชื่อกิจกรรม" required>
                @if ($errors->has('name'))
                    <div class="uk-text-danger">
                        {{ $errors->first('name') }}
                    </div>
                @endif
            </div>
        </div>
        <div class="uk-margin">
            <label class="uk-form-label" for="detail">รายละเอียด</label>
            <div class="uk-form-controls">
                <textarea id="detail" name="detail" class="uk-textarea" rows="5" placeholder="รายละเอียด" ></textarea>
            </div>
        </div>
        <div class="uk-margin">
            <label class="uk-form-label" for="pic_main">รูปหลัก</label>
            <div class="uk-form-controls">
                <label>เลือกรูปภาพ:</label>
                <small class="form-text text-muted">ไฟล์ JPG,GIF,PNG ขนาดต่ำกว่า 1Mb</small>
                <input type="file" name="mainImageFile" id="mainImageFile">
            </div>
        </div>
    </div>

    <div class="uk-margin-medium-top uk-width-1-1@m">
        <div class="uk-text-center">
            <button type="submit" class="uk-button uk-button-primary">บันทึก</button>
        </div>
    </div>
{!! Form::close() !!}<!-- form -->

<a class="uk-button uk-button-default" href="{{ url('events') }}"><span uk-icon="icon: arrow-left"></span> ย้อนกลับ</a>

@endsection