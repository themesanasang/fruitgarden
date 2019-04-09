@extends('layouts.app')

@section('script-footer')
    {!! Html::script('https://code.jquery.com/jquery.js') !!}
    
    <script>
        function initMapDetail(){
            var latR = $('#lat-detail').val();
            var longR = $('#long-detail').val()

            if(latR > 0 && longR > 0){
            var myLatLng = {lat: parseFloat(latR), lng: parseFloat(longR)};
            
            var map = new google.maps.Map(document.getElementById('map-detail'), {
                zoom: 15,
                center: myLatLng
            });

            var marker = new google.maps.Marker({
                position: myLatLng,
                map: map,
                title: ''
            });
            } 
        }
    </script> 

    {!! Html::script('https://maps.googleapis.com/maps/api/js?key=AIzaSyBFX07vo41AoaQA1BSqALrDdjrTvVwTy4E&callback=initMapDetail') !!}
 
@stop

@section('content')

@if($data->pic_main_path == '')
<div class="uk-section {{ $section_color }} uk-light uk-section-large">
@else
<div class="uk-section uk-section-large uk-light uk-background-cover" style="background-image: url({{ asset('public/'.$data->pic_main_path) }});">
@endif 
    <div class="uk-container">
        <h2 class="uk-text-center">
            <span>
                {{ $type }}
                <p><span uk-icon="icon: star"></span></p>
                <p>{{ $data->name }}</p>
            </span>
        </h2>
    </div>
</div>

<div class="uk-section uk-section-small">
    <div class="uk-container">
        <ul class="uk-breadcrumb">
            <li><a href="{{ url('home') }}">หน้าหลัก</a></li>
            <li><a href="{{ url($view_all) }}">{{ $type }}</a></li>
            <li><span>{{ $data->name }}</span></li>
        </ul>

        <article class="uk-article">

            <h1 class="uk-article-title">{{ $data->name }}</h1>
           
            <p class="uk-text-lead">{{ $data->detail }}</p>

            @if(isset($garden_name))
                <p>ชื่อสวน: {{ $garden_name }}</p>
            @endif

            <p>ที่อยู่: {{ $data->address }}</p>
            <p>เบอร์โทรศัพท์: {{ $data->phone }}</p>

            @if(isset($lat) && $lat != '')
            <p>แผนที่:</p>
                <input type="hidden" id="lat-detail" value="{{ $lat }}">
                <input type="hidden" id="long-detail" value="{{ $long }}">
                @if($lat > 0 && $long > 0)
                <div id="map-detail"></div>
                @endif
            @endif

        </article>
    </div>
</div>

@if(isset($pic) && count($pic) > 0)
<div class="uk-position-relative uk-visible-toggle uk-light" tabindex="-1" uk-slideshow="min-height: 300; max-height: 430; animation: push">

    <ul class="uk-slideshow-items">
        @foreach($pic as $key=>$value)
            <li>
                <img src="{{ asset('public/'.$value->pic_path) }}" alt="" uk-cover>
            </li>
        @endforeach
    </ul>

    <a class="uk-position-center-left uk-position-small uk-hidden-hover" href="#" uk-slidenav-previous uk-slideshow-item="previous"></a>
    <a class="uk-position-center-right uk-position-small uk-hidden-hover" href="#" uk-slidenav-next uk-slideshow-item="next"></a>

</div>
@endif

@endsection
