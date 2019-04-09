<!-- section event -->
<div class="uk-section-defalut uk-section-small">
<div class="uk-container">

    <h2 class="uk-heading-line uk-text-center uk-margin-medium-bottom"><span>กิจกรรม</span></h2>

    <div class="uk-child-width-1-3@m  uk-light" uk-grid uk-scrollspy="cls: uk-animation-fade; target: > div > .uk-card; delay: 240; repeat: true">
    
    @if(isset($event))
        @foreach($event as $key=>$value)
        <div>
            <div class="uk-card uk-card-default">
                <div class="uk-card-media-top uk-inline-clip uk-transition-toggle uk-box-shadow-small">
                    <a href="{{ url('view/event') }}/{{ $value->slug }}">
                        @if($value->pic_main_path != '')
                            <img class="uk-transition-scale-up uk-transition-opaque" src="{{ asset('public/'.$value->pic_main_path) }}" alt="">
                        @else
                            <img class="uk-transition-scale-up uk-transition-opaque" src="{{ asset('public/'.'images/bg-no-slider.jpg') }}" alt="">
                        @endif

                        <div class="uk-position-center">
                            <p class="uk-h4 uk-margin-remove">{{ $value->name }}</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    @endif     
        
    </div>

    @if(isset($event))
    <h4 class="uk-text-center uk-margin-medium-top"><span><a class="uk-link-heading" href="{{ url('view/event') }}">กิจกรรมทั้งหมด</a></span></h4>
    @endif
</div>
</div>
<!-- end section event -->