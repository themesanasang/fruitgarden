<!-- LEFT BAR -->
<aside id="left-col" class="uk-light uk-visible@m">
    <div class="left-logo uk-flex uk-flex-middle">
        ระบบจัดการ
    </div>
    <div class="left-content-box  content-box-dark">
        <h4 class="uk-text-center uk-margin-remove-vertical text-light">
            {{ Auth::user()->fullname }}
        </h4>
        
        <div class="uk-position-relative uk-text-center uk-display-block">
            <a href="#" class="uk-text-small uk-text-muted uk-display-block uk-text-center" data-uk-icon="icon: triangle-down; ratio: 0.7">
                @if(Auth::user()->level == 1)
                    ผู้ดูแลระบบ
                @else
                    ผู้ใช้งานทั่วไป
                @endif
            </a>
            <!-- user dropdown -->
            <div class="uk-dropdown user-drop" data-uk-dropdown="mode: click; pos: bottom-center; animation: uk-animation-slide-bottom-small; duration: 150">
                <ul class="uk-nav uk-dropdown-nav uk-text-left">
                        <!--<li><a href="#"><span data-uk-icon="icon: user"></span> ข้อมูลส่วนตัว</a></li>-->
                        <li><a href="{{ url('reset_password') }}"><span data-uk-icon="icon: pencil"></span> แก้ไขรหัสผ่าน</a></li>
                        <li class="uk-nav-divider"></li>
                        <li>
                            <a href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                                <span class="uk-margin-small-right" data-uk-icon="icon: sign-out"></span>  ออกจากระบบ
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                </ul>
            </div>
            <!-- /user dropdown -->
        </div>
    </div>
    
    <div class="left-nav-wrap">
        <ul class="uk-nav uk-nav-default uk-nav-parent-icon" data-uk-nav>
            <li class="uk-nav-header">เมนูจัดการ</li>
            <li><a href="{{ url('gardens') }}">สวนผลไม้</a></li>
            <li><a href="{{ url('calendars') }}">ปฏิทินผลไม้</a></li>
            <li><a href="{{ url('events') }}">กิจกรรม</a></li>
            <li><a href="{{ url('hotels') }}">ที่พัก</a></li>
            <li><a href="{{ url('restaurants') }}">ร้านอาหาร</a></li>
            <li><a href="{{ url('contact') }}">ติดต่อ</a></li>
            <li><a href="{{ url('users') }}">ผู้ใช้งาน</a></li>
            <!--<li class="uk-parent">
                <a href="#">รายงาน</a>
                <ul class="uk-nav-sub">
                    <li><a href="#">Sub item</a></li>
                    <li><a href="#">Sub item</a></li>
                </ul>
            </li>-->
        </ul>
        
    </div>
</aside>
<!-- /LEFT BAR -->