@include('header')


<header>
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 top_grid">

        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 offset-md-8">
            @if(!auth()->check())
                <a href="/registration_user"> <button class="top_grid_button_reg"><i class="fa fa-user" aria-hidden="true"></i>
                register</button></a>
            @else
                <a href="/logout"> <button class="top_grid_button_reg"><i class="fa fa-sign-out" aria-hidden="true"></i>
                logout</button></a>
            @endif
            @if(!auth()->check())
                <button class="top_grid_button_log" data-toggle="modal" data-target="#myModal"><i class="fa fa-sign-in" aria-hidden="true"></i>
                Log In</button>
            @else
                <a href="/wallet"><button class="top_grid_button_log" data-toggle="modal" data-target="#myModal" style="width:120px"><i class="fa fa-tachometer" aria-hidden="true"></i>
                dashboard</button></a>
            @endif
    
        </div>
    </div>
        <!-- header inner -->
    <div class="header">
        <div class="container-fluid pages_breadcrumb_header">
               
            <div class="row">
                <div class="col-xl-5 col-lg-5 col-md-5 col-sm-5 logo_grid">
                    <div class="logo"><a href="/"><img src="{{asset('homeassets/images/logo.jpg')}}" alt=""></a></div>
                </div>
                <div class="col-xl-7 col-lg-7 col-md-7 col-sm-7 nav_grid">
                    <div class="menu-area">
                        <div class="limit-box">
                            <nav class="main-menu">
                                <ul class="menu-area-main">
                                @if($menu_item != "")
                               
                               @foreach($menu_item as $menu)
                                   <li class="active"> <a href="{{$menu->link}}">{{$menu->label}}</a></li>
                             
                                @endforeach
                               @endif
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        <!-- end header inner -->
    </header>
    @include('frontend.layouts.modals.loginModal')

    <!-- End of breadcrumb section
        ============================================= -->

    <section id="about-page" class="about-page-section">
        <div class="container">
            <div class="row">
                <div class="@if($page->sidebar == 1) col-md-9 @else col-md-12 @endif ">
                    <div class="about-us-content-item">
                        @if($page->image != "")
                            <div class="about-gallery w-100 text-center">
                                <div class="about-gallery-img d-inline-block float-none">
                                    <img src="{{asset('storage/uploads/'.$page->image)}}" alt="">
                                </div>
                            </div>
                        @endif
                        <!-- /gallery -->
                        <div class="about-text-item">
                            <div class="section-title-2  headline text-left">
                                <h2>{{$page->title}}</h2>
                            </div>
                           {!! $page->content !!}
                        </div>
                        <!-- /about-text -->
                    </div>
                </div>
                @if($page->sidebar == 1)
                    @include('frontend.layouts.partials.right-sidebar')
                @endif
            </div>
        </div>
    </section>
    
    <!-- end clients -->
    <!-- contact -->
    
    <!-- end contact -->

    <!-- footer -->
 @include('home.footer-content')
@include('footer')