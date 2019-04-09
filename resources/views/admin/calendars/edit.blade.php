@extends('layouts.app')

@section('head')
{!! Html::style('public/css/flatpickr.min.css') !!}
@stop

@section('script-footer')
{!! Html::script('https://code.jquery.com/jquery.js') !!}
{!! Html::script('public/js/flatpickr.min.js') !!}
{!! Html::script('public/js/th.js') !!}

<script>
    $(function(){
        var d1 = {!! json_encode($calendar->start_date) !!}; 
        d1 = d1.split('-');

        $("#start_date").flatpickr({
            "locale": "th",
            "dateFormat": "d-m-Y",
            defaultDate: d1[2]+'-'+d1[1]+'-'+d1[0]
        });

        var d2 = {!! json_encode($calendar->end_date) !!}; 
        d2 = d2.split('-');

        $("#end_date").flatpickr({
            "locale": "th",
            "dateFormat": "d-m-Y",
            defaultDate: d2[2]+'-'+d2[1]+'-'+d2[0]
        });
    });
</script>

@stop

@section('content')
<h3>แก้ไขข้อมูล ปฏิทิน กิจกรรม</h3>
<hr>

{!! Form::open( array('route' => ['calendars.update', Crypt::encryptString($calendar['id'])], 'class' => 'uk-form-horizontal uk-margin-small uk-grid', 'method' => 'PATCH') ) !!}
<div class="uk-width-1-1@m">
        

   <div class="uk-width-1-1@m">
        <div class="uk-margin">
            <label class="uk-form-label" for="title">ชื่อกิจกรรม <span class="uk-text-danger">*</span></label>
            <div class="uk-form-controls">
                <input class="uk-input {{ $errors->has('title') ? ' uk-form-danger' : '' }}" id="title" type="text" name="title" value="{{ $calendar->title }}" placeholder="ชื่อกิจกรรม" required>
                @if ($errors->has('title'))
                    <div class="uk-text-danger">
                        {{ $errors->first('title') }}
                    </div>
                @endif
            </div>
        </div>
        <div class="uk-margin">
            <label class="uk-form-label" for="detail">วันที่เริ่ม(ว-ด-ป) <span class="uk-text-danger">*</span></label>
            <div class="uk-form-controls">
                <input class="uk-input" id="start_date" name="start_date" type="text"  value="{{ $calendar->start_date }}" placeholder="วันที่เริ่ม">
            </div>
        </div>
        <div class="uk-margin">
            <label class="uk-form-label" for="detail">วันที่สิ้นสุด(ว-ด-ป) <span class="uk-text-danger">*</span></label>
            <div class="uk-form-controls">
                <input class="uk-input" id="end_date" name="end_date" type="text" value="{{ $calendar->end_date }}" placeholder="วันที่สิ้นสุด"> 
            </div>
        </div>
    </div>

    <div class="uk-margin-medium-top uk-width-1-1@m">
        <div class="uk-text-center">
            <button type="submit" class="uk-button uk-button-primary">บันทึก</button>
        </div>
    </div>
{!! Form::close() !!}<!-- form -->

<a class="uk-button uk-button-default" href="{{ url('calendars') }}"><span uk-icon="icon: arrow-left"></span> ย้อนกลับ</a>

@endsection