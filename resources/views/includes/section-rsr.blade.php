<!-- section rsr  -->
<div class="uk-section-defalut ">
<div class="uk-position-relative uk-visible-toggle uk-light" tabindex="-1" uk-slider="clsActivated: uk-transition-active; center: true">

    <ul class="uk-slider-items uk-child-width-1-2 uk-child-width-1-2@s uk-child-width-1-3@m">
    @if(isset($restaurants))
            @foreach($restaurants as $key=>$value)
            <li>
                <div class="uk-panel">
                    @if($value->pic_main_path != '')
                        <img src="{{ asset('public/'.$value->pic_main_path) }}" alt="">
                    @else
                        <img src="{{ asset('public/'.'images/bg-no-slider.jpg') }}" alt="">
                    @endif
                    <div class="uk-overlay uk-overlay-primary uk-position-bottom uk-text-center uk-transition-slide-bottom">
                        <h3 class="uk-margin-remove">{{ $value->name }}</h3>
                    </div>
                </div>
            </li>
            @endforeach
        @endif      
    </ul>

    <a class="uk-position-center-left uk-position-small uk-hidden-hover" href="#" uk-slidenav-previous uk-slider-item="previous"></a>
    <a class="uk-position-center-right uk-position-small uk-hidden-hover" href="#" uk-slidenav-next uk-slider-item="next"></a>

</div>
</div>
<!-- end section rsr  -->