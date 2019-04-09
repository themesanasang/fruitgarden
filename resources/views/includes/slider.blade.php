<!-- slider  -->
<div class="uk-position-relative uk-visible-toggle uk-light" tabindex="-1" uk-slideshow="animation: push; autoplay: true; autoplay-interval: 6000; min-height: 300; max-height: 600;">

    <ul class="uk-slideshow-items">

        @if(isset($slider))
            @foreach($slider as $key=>$value)
            <li>
                <div class="uk-position-cover uk-animation-kenburns uk-animation-reverse uk-transform-origin-center-left">
                    <img data-src="{{ asset('public/'.$value->pic_main_path) }}"  alt="{{ $value->name }}" uk-img uk-cover />
                </div>
                <div class="uk-position-cover" uk-slideshow-parallax="opacity: 0,0,0.2; backgroundColor: #000,#000"></div>
                <div class="uk-position-center uk-position-medium uk-text-center">
                    <div uk-slideshow-parallax="scale: 1,1,0.8">
                        <h2 uk-slideshow-parallax="x: 200,0,0">{{ $value->name }}</h2>
                    </div>
                </div>
            </li>
            @endforeach
        @else
            <li>
                <div class="uk-position-cover uk-animation-kenburns uk-animation-reverse uk-transform-origin-center-left">
                    <img src="{{ asset('public/'.'images/bg-no-slider.jpg') }}" alt="" uk-cover>
                </div>
                <div class="uk-position-cover" uk-slideshow-parallax="opacity: 0,0,0.2; backgroundColor: #000,#000"></div>
                <div class="uk-position-center uk-position-medium uk-text-center">
                    <div uk-slideshow-parallax="scale: 1,1,0.8">
                        <h2 uk-slideshow-parallax="x: 200,0,0">สวนผลไม้แนะนำ</h2>
                    </div>
                </div>
            </li>
        @endif         
    </ul>

    <a class="uk-position-center-left uk-position-small uk-hidden-hover" href="#" uk-slidenav-previous uk-slideshow-item="previous"></a>
    <a class="uk-position-center-right uk-position-small uk-hidden-hover" href="#" uk-slidenav-next uk-slideshow-item="next"></a>

</div>
<!-- end slider  -->