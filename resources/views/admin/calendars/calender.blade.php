@extends('layouts.app')

@section('head')   
    {!! Html::style('https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.css') !!}
@stop

@section('script-footer')
    {!! Html::script('https://code.jquery.com/jquery.js') !!}
    {!! Html::script('https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js') !!}
    {!! Html::script('https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.js') !!}
   
    {!! $calendar->script() !!}
@stop

@section('content')

<h3>ปฏิทิน</h3>
<hr>

{!! $calendar->calendar() !!}

<a class="uk-button uk-button-default uk-margin-small-top" href="{{ url('calendars') }}"><span uk-icon="icon: arrow-left"></span> ย้อนกลับ</a>

@endsection