<!--HEADER-->
<header id="top-head" class="uk-position-fixed">
    <div class="uk-container uk-container-expand uk-background-navbar-admin-top">
        <nav class="uk-navbar uk-light" data-uk-navbar="mode:click; duration: 250">
            <div class="uk-navbar-right">
                <ul class="uk-navbar-nav">
                    <li><a href="#" data-uk-icon="icon:user" title="ข้อมูลส่วนตัว" data-uk-tooltip></a></li>
                    <li>
                        <a href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                            <span data-uk-icon="icon: sign-out" title="ออกจากระบบ" data-uk-tooltip></span>
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </li>
                    <li class="uk-hidden@s"><a class="uk-navbar-toggle" data-uk-toggle data-uk-navbar-toggle-icon href="#offcanvas-nav" title="เมนูจัดการ" data-uk-tooltip></a></li>
                </ul>
            </div>
        </nav>
    </div>
</header>
        
<!-- OFFCANVAS -->
<div id="offcanvas-nav" data-uk-offcanvas="flip: true; overlay: true">
    <div class="uk-offcanvas-bar uk-offcanvas-bar-animation uk-offcanvas-slide">
        <button class="uk-offcanvas-close uk-close uk-icon" type="button" data-uk-close></button>
        <ul class="uk-nav uk-nav-default">
            <li class="uk-active"><a href="#">Active</a></li>
            <li class="uk-nav-header">Header</li>
            <li><a href="#js-options"><span class="uk-margin-small-right uk-icon" data-uk-icon="icon: table"></span> Item</a></li>
            <li><a href="#"><span class="uk-margin-small-right uk-icon" data-uk-icon="icon: thumbnails"></span> Item</a></li>
            <li class="uk-nav-divider"></li>
            <li><a href="#"><span class="uk-margin-small-right uk-icon" data-uk-icon="icon: trash"></span> Item</a></li>
        </ul>
    </div>
</div>
<!-- /OFFCANVAS -->
<!--/HEADER-->