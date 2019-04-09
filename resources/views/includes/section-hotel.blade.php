<!-- section hotel  -->
<div class="uk-section-default uk-section-small uk-padding-remove-bottom">
<div class="uk-section uk-light uk-background-cover" style="background-image: url({{ asset('public/'.'images/bg-h01.jpg') }})">
    <div class="uk-container">

        <h2 class="uk-heading-line uk-text-center uk-margin-medium-bottom"><span>ที่พัก</span></h2>

        <div class="uk-child-width-1-4@m" uk-grid uk-scrollspy="cls: uk-animation-fade; target: > div > .uk-card; delay: 240; repeat: true">
        
        @if(isset($hotel))
            @foreach($hotel as $key=>$value)
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
                        <h3 class="uk-card-title"><a class="uk-link-card" href="{{ url('view/hotel') }}/{{ $value->slug }}">{{ $value->name }}</a></h3>
                    </div>
                </div>
            </div>
            @endforeach
        @endif     
            
        </div>

        @if(isset($hotel))
        <h4 class="uk-text-center uk-margin-medium-top"><span><a class="uk-link-heading" href="{{ url('view/hotel') }}">ที่พักทั้งหมด</a></span></h4>
        @endif
    </div>
</div>
</div>
<!-- end section hotel  -->