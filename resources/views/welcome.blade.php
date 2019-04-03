<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <title>Fruit Garden</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="@yield('description', config('app.description'))"/>
        <meta name="keywords" content="@yield('keywords', config('app.keywords'))"/>
        <meta name="copyright" content="{{ config('app.name') }}">
        <meta name="author" content="{{ config('app.name') }}"/>
        <meta name="application-name" content="@yield('title', config('app.name'))">
        
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link rel="shortcut icon" href="{{ asset('public/favicon.ico') }}" type="image/x-icon">
        <link rel="icon" href="{{ asset('public/favicon.ico') }}" type="image/x-icon">
        <!-- Styles -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="{{ asset('public/css/uikit.min.css') }}">
        <link rel="stylesheet" href="{{ asset('public/css/theme.css') }}">    
    </head>
    <body>
        
        <div class="uk-section-default uk-preserve-color">

            <!--<div uk-sticky="animation: uk-animation-slide-top; sel-target: .uk-navbar-container; cls-active: uk-navbar-sticky; top: 300">-->
            <div>
                <nav class="uk-navbar-container">
                    <div class="uk-container uk-container-expand uk-background-navbar-top">
                        <div uk-navbar>

                            <div class="uk-navbar-left">
                                <ul class="uk-navbar-nav">
                                    <a class="uk-navbar-item uk-logo" href="#">Logo</a>
                                 </ul>
                            </div>

                            <div class="uk-navbar-right">
                                <ul class="uk-navbar-nav">
                                    <li class="uk-active"><a href="#">หน้าหลัก</a></li>
                                    <li><a href="#">สวนผลไม้</a></li>
                                    <li><a href="#">กิจกรรม</a></li>
                                    <li><a href="#">ที่พัก</a></li>
                                    <li><a href="#">ร้านอาหาร</a></li>
                                    <li><a href="#">ติดต่อเรา</a></li>
                                </ul>
                            </div>

                        </div>
                    </div>
                </nav>
            </div>
            <!-- end menu top  -->

            <div class="uk-position-relative uk-visible-toggle uk-light" tabindex="-1" uk-slideshow="animation: push; autoplay: true; autoplay-interval: 6000; min-height: 300; max-height: 600;">

                <ul class="uk-slideshow-items">
                    <li>
                        <div class="uk-position-cover uk-animation-kenburns uk-animation-reverse uk-transform-origin-center-left">
                            <img src="images/h-test1.jpg" alt="" uk-cover>
                        </div>
                        <div class="uk-position-cover" uk-slideshow-parallax="opacity: 0,0,0.2; backgroundColor: #000,#000"></div>
                        <div class="uk-position-center uk-position-medium uk-text-center">
                            <div uk-slideshow-parallax="scale: 1,1,0.8">
                                <h2 uk-slideshow-parallax="x: 200,0,0">สวนทดสอบ</h2>
                                <p uk-slideshow-parallax="x: 400,0,0;">
                                    ที่สวนสุภัทรามีบริการพาเราเข้าไปชมสวนด้วยรถรางค่ะ จะมีทั้งสวนเงาะ, ซุ้มกระท้อน, ศาลาองุ่นฯ  นอกจากได้ชิมผลไม้สดๆ ถึงต้นแล้ว ยังได้ความรู้จากการดูงานวิชาการเชิงการเกษตรโดยวิทยากรผู้เชี่ยวชาญอีกด้วยค่ะ
                                </p>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="uk-position-cover uk-animation-kenburns uk-animation-reverse uk-transform-origin-top-right">
                            <img src="images/h-test2.jpg" alt="" uk-cover>
                        </div>
                        <div class="uk-position-cover" uk-slideshow-parallax="opacity: 0,0,0.2; backgroundColor: #000,#000"></div>
                        <div class="uk-position-center uk-position-medium uk-text-center">
                            <div uk-slideshow-parallax="scale: 1,1,0.8">
                                <h2 uk-slideshow-parallax="x: 200,0,0">สวนทดสอบ</h2>
                                <p uk-slideshow-parallax="x: 400,0,0;">
                                    ที่นี่มีต้นมังคุดกว่า 300 ต้นค่ะ อีกทั้งผลไม้หลากหลายชนิดประกอบ ไม่ว่าจะเป็น มะยงชิด มะม่วง มะพร้าว เงาะ แต่จุดเด่นอยู่ที่ผลของมังคุดมีคุณภาพ
                                </p>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="uk-position-cover uk-animation-kenburns uk-animation-reverse uk-transform-origin-bottom-left">
                            <img src="images/h-test3.jpg" alt="" uk-cover>
                        </div>
                        <div class="uk-position-cover" uk-slideshow-parallax="opacity: 0,0,0.2; backgroundColor: #000,#000"></div>
                        <div class="uk-position-center uk-position-medium uk-text-center">
                            <div uk-slideshow-parallax="scale: 1,1,0.8">
                                <h2 uk-slideshow-parallax="x: 200,0,0">สวนทดสอบ</h2>
                                <p uk-slideshow-parallax="x: 400,0,0;">สวนประสมทรัพย์ เป็นสวนท่องเที่ยวเชิงเกษตรจำนวน 9 ไร่ โดยมีพื้นที่ที่เป็นบ้านพักอาศัยรวมอยู่ด้วยค่ะ เพราะฉะนั้นถ้าได้มีไปเที่ยวที่นี่ก็สามารถค้างคืนได้ด้วย</p>
                            </div>
                        </div>
                    </li>
                </ul>

                <a class="uk-position-center-left uk-position-small uk-hidden-hover" href="#" uk-slidenav-previous uk-slideshow-item="previous"></a>
                <a class="uk-position-center-right uk-position-small uk-hidden-hover" href="#" uk-slidenav-next uk-slideshow-item="next"></a>

            </div>
            <!-- end slider  -->

            <div class="uk-section uk-section-small">
                <div class="uk-container">

                <h2 class="uk-heading-line uk-text-center uk-margin-medium-bottom"><span>สวนผลไม้</span></h2>

                <div class="uk-child-width-1-3@m" uk-grid uk-scrollspy="cls: uk-animation-fade; target: > div > .uk-card; delay: 250; repeat: true">
                <!--<div class="uk-child-width-1-3@m" uk-grid>-->
                    <div>
                        <div class="uk-card uk-card-default">
                            <div class="uk-card-media-top">
                                <img src="images/h-test4.jpg" alt="">
                            </div>
                            <div class="uk-card-body">
                                <h3 class="uk-card-title">สวนทดสอบ</h3>
                            </div>
                        </div>
                    </div>
                    <div>
                    <div class="uk-card uk-card-default">
                            <div class="uk-card-media-top">
                                <img src="images/h-test5.jpg" alt="">
                            </div>
                            <div class="uk-card-body">
                                <h3 class="uk-card-title">สวนทดสอบ</h3>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="uk-card uk-card-default">
                            <div class="uk-card-media-top">
                                <img src="images/h-test3.jpg" alt="">
                            </div>
                            <div class="uk-card-body">
                                <h3 class="uk-card-title">สวนทดสอบ</h3>
                            </div>
                        </div>
                    </div>
                </div>

                <h4 class="uk-text-center uk-margin-medium-top"><span><a class="uk-link-heading link-all" href="#">สวนผลไม้ทั้งหมด</a></span></h4>

                </div>
            </div>
            <!-- end section 1  -->

            <div class="uk-section-defalut uk-section-small">
                <div class="uk-container">

                    <h2 class="uk-heading-line uk-text-center uk-margin-medium-bottom"><span> ปฏิทิน ผลไม้</span></h2>

                    <div class="uk-card uk-card-default uk-card-body">
                        <img src="images/calendar.png">
                    </div>

                </div>
            </div>
             <!-- end section 2  -->

             <div class="uk-section-defalut uk-section-small">
                <div class="uk-container">

                    <h2 class="uk-heading-line uk-text-center uk-margin-medium-bottom"><span>กิจกรรม</span></h2>

                    <div class="uk-child-width-1-3@m  uk-light" uk-grid uk-scrollspy="cls: uk-animation-fade; target: > div > .uk-card; delay: 250; repeat: true">
                    <!--<div class="uk-child-width-1-3@m" uk-grid>-->    
                        <div>
                            <div class="uk-card uk-card-default">
                                <div class="uk-card-media-top uk-inline-clip uk-transition-toggle uk-box-shadow-small">
                                    <a href="#">
                                        <img class="uk-transition-scale-up uk-transition-opaque" src="images/h-test3.jpg" alt="">
                                        <div class="uk-position-center">
                                            <p class="uk-h4 uk-margin-remove">เก็บผลไม้</p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="uk-card uk-card-default">
                                <div class="uk-card-media-top uk-inline-clip uk-transition-toggle uk-box-shadow-small">
                                    <a href="#">
                                        <img class="uk-transition-scale-up uk-transition-opaque" src="images/h-test2.jpg" alt="">
                                        <div class="uk-position-center">
                                            <p class="uk-h4 uk-margin-remove">เก็บผลไม้</p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="uk-card uk-card-default">
                                <div class="uk-card-media-top uk-inline-clip uk-transition-toggle uk-box-shadow-small">
                                    <a href="#">
                                        <img class="uk-transition-scale-up uk-transition-opaque" src="images/h-test7.jpg" alt="">
                                        <div class="uk-position-center">
                                            <p class="uk-h4 uk-margin-remove">เก็บผลไม้</p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="uk-card uk-card-default">
                                <div class="uk-card-media-top uk-inline-clip uk-transition-toggle uk-box-shadow-small">
                                    <a href="#">
                                        <img class="uk-transition-scale-up uk-transition-opaque" src="images/h-test8.jpg" alt="">
                                        <div class="uk-position-center">
                                            <p class="uk-h4 uk-margin-remove">เก็บผลไม้</p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="uk-card uk-card-default">
                                <div class="uk-card-media-top uk-inline-clip uk-transition-toggle uk-box-shadow-small">
                                    <a href="#">
                                        <img class="uk-transition-scale-up uk-transition-opaque" src="images/h-test10.jpg" alt="">
                                        <div class="uk-position-center">
                                            <p class="uk-h4 uk-margin-remove">เก็บผลไม้</p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="uk-card uk-card-default">
                                <div class="uk-card-media-top uk-inline-clip uk-transition-toggle uk-box-shadow-small">
                                    <a href="#">
                                        <img class="uk-transition-scale-up uk-transition-opaque" src="images/h-test2.jpg" alt="">
                                        <div class="uk-position-center">
                                            <p class="uk-h4 uk-margin-remove">เก็บผลไม้</p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                       
                    </div>

                    <h4 class="uk-text-center uk-margin-medium-top"><span><a class="uk-link-heading" href="#">กิจกรรมทั้งหมด</a></span></h4>

                </div>
            </div>
             <!-- end section 3  -->

            <div class="uk-section-default uk-section-small uk-padding-remove-bottom">
            <div class="uk-section uk-light uk-background-cover" style="background-image: url(images/bg-h01.jpg)">
                <div class="uk-container">

                    <h2 class="uk-heading-line uk-text-center uk-margin-medium-bottom"><span>ที่พัก</span></h2>

                    <div class="uk-child-width-1-4@m" uk-grid uk-scrollspy="cls: uk-animation-fade; target: > div > .uk-card; delay: 250; repeat: true">
                    <!--<div class="uk-child-width-1-4@m" uk-grid>-->
                        <div>
                            <div class="uk-card uk-card-default">
                                <div class="uk-card-media-top">
                                    <img src="images/h-test13.jpg" alt="">
                                </div>
                                <div class="uk-card-body">
                                    <h3 class="uk-card-title">ที่พัก</h3>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="uk-card uk-card-default">
                                <div class="uk-card-media-top">
                                    <img src="images/h-test13.jpg" alt="">
                                </div>
                                <div class="uk-card-body">
                                    <h3 class="uk-card-title">ที่พัก</h3>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="uk-card uk-card-default">
                                <div class="uk-card-media-top">
                                    <img src="images/h-test13.jpg" alt="">
                                </div>
                                <div class="uk-card-body">
                                    <h3 class="uk-card-title">ที่พัก</h3>
                                </div>
                            </div>
                        </div>

                        <div>
                            <div class="uk-card uk-card-default">
                                <div class="uk-card-media-top">
                                    <img src="images/h-test13.jpg" alt="">
                                </div>
                                <div class="uk-card-body">
                                    <h3 class="uk-card-title"> ที่พัก</h3>
                                </div>
                            </div>
                        </div>
                    </div>

                    <h4 class="uk-text-center uk-margin-medium-top"><span><a class="uk-link-heading" href="#">ที่พักทั้งหมด</a></span></h4>

                </div>
            </div>
            </div>
             <!-- end section 4  -->

            <div class="uk-section-defalut ">

                <div class="uk-position-relative uk-visible-toggle uk-light" tabindex="-1" uk-slider="clsActivated: uk-transition-active; center: true">

                    <ul class="uk-slider-items uk-child-width-1-2 uk-child-width-1-2@s uk-child-width-1-3@m">
                        <li>
                            <div class="uk-panel">
                                <img src="images/h-test15.jpg" alt="">
                                <div class="uk-overlay uk-overlay-primary uk-position-bottom uk-text-center uk-transition-slide-bottom">
                                    <h3 class="uk-margin-remove">ร้านอาหาร</h3>
                                    <p class="uk-margin-remove">เปิดมา 20 ปี</p>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="uk-panel">
                                <img src="images/h-test16.jpg" alt="">
                                <div class="uk-overlay uk-overlay-primary uk-position-bottom uk-text-center uk-transition-slide-bottom">
                                    <h3 class="uk-margin-remove">ร้านอาหาร</h3>
                                    <p class="uk-margin-remove">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="uk-panel">
                                <img src="images/h-test17.jpg" alt="">
                                <div class="uk-overlay uk-overlay-primary uk-position-bottom uk-text-center uk-transition-slide-bottom">
                                    <h3 class="uk-margin-remove">ร้านอาหาร</h3>
                                    <p class="uk-margin-remove">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="uk-panel">
                                <img src="images/h-test16.jpg" alt="">
                                <div class="uk-overlay uk-overlay-primary uk-position-bottom uk-text-center uk-transition-slide-bottom">
                                    <h3 class="uk-margin-remove">ร้านอาหาร</h3>
                                    <p class="uk-margin-remove">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="uk-panel">
                                <img src="images/h-test2.jpg" alt="">
                                <div class="uk-overlay uk-overlay-primary uk-position-bottom uk-text-center uk-transition-slide-bottom">
                                    <h3 class="uk-margin-remove">ร้านอาหาร</h3>
                                    <p class="uk-margin-remove">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                                </div>
                            </div>
                        </li>
                        <li>
                             <div class="uk-panel">
                                <img src="images/h-test3.jpg" alt="">
                                <div class="uk-overlay uk-overlay-primary uk-position-bottom uk-text-center uk-transition-slide-bottom">
                                    <h3 class="uk-margin-remove">ร้านอาหาร</h3>
                                    <p class="uk-margin-remove">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                                </div>
                            </div>
                        </li>
                    </ul>

                    <a class="uk-position-center-left uk-position-small uk-hidden-hover" href="#" uk-slidenav-previous uk-slider-item="previous"></a>
                    <a class="uk-position-center-right uk-position-small uk-hidden-hover" href="#" uk-slidenav-next uk-slider-item="next"></a>

                </div>

            </div>
             <!-- end section 5  -->




        </div>

        <div class="uk-section uk-section-secondary uk-light uk-section-small">
            <div class="uk-container">

            <div class="uk-grid-match uk-child-width-1-4@m" uk-grid>
                <div>
                    Logo
                </div>
                <div>
                    <h5 class="uk-margin-small-bottom">เกี่ยวกับเรา</h5>
                    <p class="uk-margin-remove-top">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor.</p>
                </div>
                <div>
                    <h5 class="uk-margin-small-bottom">ติดต่อเรา</h5>
                    <p class="uk-margin-remove-top">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor.</p>
                </div>
                <div>
                    <h5 class="uk-margin-small-bottom">ติดตาม</h5>
                    <ul class="uk-list uk-margin-remove-top">
                        <li>Facebook</li>
                        <li>Twitter</li>
                        <li>Instagram</li>
                    </ul>
                </div>
            </div>
            
            </div>
        </div>
         <!-- end footer  -->



        <!-- Scripts -->
        <script src="{{ asset('public/js/uikit.min.js') }}"></script>
        <script src="{{ asset('public/js/uikit-icons.min.js') }}"></script>

    </body>
</html>
