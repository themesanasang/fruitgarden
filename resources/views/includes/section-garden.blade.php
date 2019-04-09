<!-- section garden  -->
<div class="uk-section uk-section-small">
<div class="uk-container">

<h2 class="uk-heading-line uk-text-center uk-margin-medium-bottom"><span>สวนผลไม้</span></h2>

<div class="uk-child-width-1-3@m" uk-grid uk-scrollspy="cls: uk-animation-fade; target: > div > .uk-card; delay: 240; repeat: true">
    
    @if(isset($garden))
        @foreach($garden as $key=>$value)
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
                    <h3 class="uk-card-title"><a class="uk-link-card" href="{{ url('view/garden') }}/{{ $value->slug }}">{{ $value->name }}</a></h3>
                </div>
            </div>
        </div>
        @endforeach
    @endif  
    
</div>

@if(isset($garden))
    <h4 class="uk-text-center uk-margin-medium-top"><span><a class="uk-link-heading link-all" href="{{ url('view/garden') }}">สวนผลไม้ทั้งหมด</a></span></h4>
@endif  

</div>
</div>
<!-- end section garden  -->