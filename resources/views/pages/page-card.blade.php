@extends('layouts.app')

@section('content')

<div class="uk-section {{ $section_color }} uk-light uk-section-xsmall">
    <div class="uk-container">
        <h2 class="uk-text-center">
            <span>
                {{ $type }}
            </span>
        </h2>
    </div>
</div>

<div class="uk-section uk-section-small">
    <div class="uk-container">
        <ul class="uk-breadcrumb">
            <li><a href="{{ url('home') }}">หน้าหลัก</a></li>
            <li><span> {{ $type }}</span></li>
        </ul>

        @if(isset($data))
            <div class="uk-child-width-1-3@m" uk-grid uk-scrollspy="cls: uk-animation-fade; target: > div > .uk-card; delay: 240; repeat: true">
            @foreach($data as $key=>$value)        
                <div>
                    <div class="uk-card uk-card-default uk-box-shadow-small uk-box-shadow-hover-large">
                        <div class="uk-card-media-top">
                            @if($value->pic_main_path != '')
                                <img src="{{ asset('public/'.$value->pic_main_path) }}" alt="">
                            @else
                                <img src="{{ asset('public/'.'images/bg-no-slider.jpg') }}" alt="">
                            @endif
                        </div>
                        <div class="uk-card-body">
                            <h3 class="uk-card-title"><a class="uk-link-card" href="{{ url( $view_all ) }}/{{ $value->slug }}">{{ $value->name }}</a></h3>
                        </div>
                    </div>
                </div>
            @endforeach
            </div>

            @include('layouts.pagination', ['paginator' => $data, 'interval' => 5])
        @endif   
        
    </div>
</div>



@endsection
