 
 <?php 
  function current_page($uri = "/") { 
    return strstr(request()->path(), $uri); 
  } 
?>
 
 <!-- menu top  -->
 <div uk-sticky="animation: uk-animation-slide-top; sel-target: .uk-navbar-container; cls-active: uk-navbar-sticky; top: 300">
 <!--<div>-->
    <nav class="uk-navbar-container">
        <div class="uk-container uk-container-expand uk-background-navbar-top">
            <div uk-navbar>

                <div class="uk-navbar-left">
                    <ul class="uk-navbar-nav">
                        <a class="uk-navbar-item uk-logo" href="{{ url('/') }}">Logo</a>
                    </ul>
                </div>

                <div class="uk-navbar-right">
                    <ul class="uk-navbar-nav">
                        <li class="{{ current_page('home') ? 'uk-active' : null }}"><a href="{{ url('home') }}">หน้าหลัก</a></li>
                        <li class="{{ current_page('/garden') ? 'uk-active' : null }}"><a href="{{ url('view/garden') }}">สวนผลไม้</a></li>
                        <li class="{{ current_page('/event') ? 'uk-active' : null }}"><a href="{{ url('view/event') }}">กิจกรรม</a></li>
                        <li class="{{ current_page('/hotel') ? 'uk-active' : null }}"><a href="{{ url('view/hotel') }}">ที่พัก</a></li>
                        <li class="{{ current_page('/restaurants') ? 'uk-active' : null }}"><a href="{{ url('view/restaurants') }}">ร้านอาหาร</a></li>
                        <li class="{{ current_page('/contact') ? 'uk-active' : null }}"><a href="{{ url('view/contact') }}">ติดต่อเรา</a></li>
                    </ul>
                </div>

            </div>
        </div>
    </nav>
</div>
<!-- end menu top  -->