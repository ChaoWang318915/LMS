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
        </div>
    </div>
        <!-- end header inner -->
</header>
 @include('frontend.layouts.modals.loginModal')
    <section id="about-page" class="about-page-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="about-us-content-item">
                         
                        <div class="about-text-item">
                            <div class="section-title-2  headline text-left">
                                <h2>Password Reset</h2>
                            </div>
                            <section id="about-page" class="about-page-section pb-0">
                                <div class="row justify-content-center align-items-center">
                                    <div class="col col-md-4 align-self-center">
                                        <div class="card border-0">
                        
                                            <div class="card-body">
                        
                                                @if(session('status'))
                                                    <div class="alert alert-success">
                                                        {{ session('status') }}
                                                    </div>
                                                @endif
                        
                                                {{ html()->form('POST', route('frontend.auth.password.email.post'))->open() }}
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="form-group">
                                                            {{ html()->email('email')
                                                                ->class('form-control')
                                                                ->placeholder(__('validation.attributes.frontend.email'))
                                                                ->attribute('maxlength', 191)
                                                                ->required()
                                                                ->autofocus() }}
                                                        </div><!--form-group-->
                                                    </div><!--col-->
                                                </div><!--row-->
                        
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="form-group mb-0 clearfix">
                                                            <div class="text-center  text-capitalize">
                                                                <button type="submit" class="nws-button btn-info btn "
                                                                        value="Submit">{{__('labels.frontend.passwords.send_password_reset_link_button')}}</button>
                                                            </div>
                                                        </div><!--form-group-->
                                                    </div><!--col-->
                                                </div><!--row-->
                                                {{ html()->form()->close() }}
                                            </div><!-- card-body -->
                                        </div><!-- card -->
                                    </div><!-- col-6 -->
                                </div><!-- row -->
                            </section>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </section>
 @include('home.footer-content')
@include('footer')