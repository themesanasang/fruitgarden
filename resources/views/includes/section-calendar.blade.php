@section('head')   
    {!! Html::style('https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.css') !!}
@stop

@section('script-footer')
    {!! Html::script('https://code.jquery.com/jquery.js') !!}
    {!! Html::script('https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js') !!}
    {!! Html::script('https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.js') !!}
   
    {!! $calendar->script() !!}
@stop
<!-- section calendar  -->
<div class="uk-section-defalut uk-section-small">
    <div class="uk-container">
        <h2 class="uk-heading-line uk-text-center uk-margin-medium-bottom"><span> ปฏิทิน ผลไม้</span></h2>

        <div class="uk-card uk-card-default uk-card-body uk-box-shadow-small uk-box-shadow-hover-large">
            {!! $calendar->calendar() !!}
        </div>
    </div>
</div>
<!-- end section calendar  -->