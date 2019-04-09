@extends('layouts.app')

@section('content')
<h3>แก้ไขข้อมูล กิจกรรม</h3>
<hr>

{!! Form::open( array('route' => ['events.update', Crypt::encryptString($event['id'])], 'enctype' => 'multipart/form-data', 'class' => 'uk-form-horizontal uk-margin-small uk-grid', 'method' => 'PATCH') ) !!}
<div class="uk-width-1-1@m">
        <div class="uk-margin">
            <label class="uk-form-label" for="name">ชื่อสวนผลไม้ <span class="uk-text-danger">*</span></label>
            <div class="uk-form-controls">
            {!! Form::select('garden_id', $garden, $event->garden_id, ['class'=> 'uk-select', 'id' => 'garden_id']) !!} 
            </div>
        </div>
        <div class="uk-margin">
            <label class="uk-form-label" for="name">ชื่อกิจกรรม <span class="uk-text-danger">*</span></label>
            <div class="uk-form-controls">
                <input class="uk-input" id="name" type="text" name="name" value="{{ $event->name }}">
            </div>
        </div>
        <div class="uk-margin">
            <label class="uk-form-label" for="detail">รายละเอียด</label>
            <div class="uk-form-controls">
                <textarea id="detail" name="detail" class="uk-textarea" rows="5" placeholder="รายละเอียด" >{{ $event->detail }}</textarea>
            </div>
        </div>
        <div class="uk-margin">
            <label class="uk-form-label" for="pic_main">รูปหลัก</label>
            <div class="uk-form-controls">
                <label>เลือกรูปภาพ:</label>
                <small class="form-text text-muted">ไฟล์ JPG,GIF,PNG ขนาดต่ำกว่า 1Mb</small>
                <input type="file" name="mainImageFile" id="mainImageFile">
                @if($event->pic_main_name != "")
                    <img class="uk-responsive-width" data-src="{{ asset('public/'.$event->pic_main_path) }}" width="360" height="260" alt="" uk-img />
                @endif
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