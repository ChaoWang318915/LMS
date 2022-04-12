@include('header')
<style>
.loader{
  position: fixed;
  left: 0px;
  top: 0px;
  width: 100%;
  height: 100%;
  z-index: 9999;
  background: url('//upload.wikimedia.org/wikipedia/commons/thumb/e/e5/Phi_fenomeni.gif/50px-Phi_fenomeni.gif') 
              50% 50% no-repeat rgb(249,249,249);
}
.nice-select{
    width:100% ;
    line-height:30px;
}
</style>
<header>
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 top_grid">

        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 offset-md-8">
            @if(!auth()->check())
                <a href="/registration_user"> <button class="top_grid_button_reg"><i class="fa fa-user" aria-hidden="true"></i>
                    register</button></a>
            @else
                <a href="/logout"> <button class="top_grid_button_reg"><i class="fa fa-sign-out" aria-hidden="true"></i>
                </i>logout</button></a>
    
            @endif
    
            @if(!auth()->check())
                <button class="top_grid_button_log" data-toggle="modal" data-target="#myModal"><i class="fa fa-sign-in" aria-hidden="true"></i>
                Log In</button>
            @else
                <a href="/wallet"><button class="top_grid_button_log" data-toggle="modal" data-target="#myModal" style="width:120px"><i class="fa fa-sign-in" aria-hidden="true"></i>
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
    
    <section id="breadcrumb" class=" relative-position backgroud-style">
        <div class="blakish-overlay"></div>
        <div class="container">
        </div>
    </section>
    
    <section id="about-page" class="about-page-section pb-0">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 offset-sm-3">
                    <div class="card  border-0">
                        <div class="card-body">
                            <div class="loader" id="showloader">Loading...</div>                        
                             <span class="success-response text-success">{{(session()->get('flash_success'))}}</span>
                            <div class="container">
                                <h1 class="text-uppercase text-center"><b><span style="color:#1672b5">Welcome to Dotcom Lessons!</span></b></h1>
                                <h3 class=""> Hi There!<br> <br>You are now part of a growing community with the goal to help improve your credit.<br><br>
                                Please check your email so you can start the process of confirming your information. <br><br>
                                To sign into your account simply click the log in button at the top of this page. 
                                If you have any questions regarding your account, please contact us and we will be happy to help.<br><br>
                                Allen Brown<br>
                                Founder Dotcom Lessons<br>
                                <a href="https://dotcomlessons.com">DotcomLessons.com</a>
                                
                                <br><br>
                                <span style="color:#1672b5">Please Note:</span> Emails sometimes can reach your spam folder. Make sure to look for an email from welcome@dotcomlessons.com  </h3>
                                <!--<h1 class="text-uppercase text-center">You will receive up to $2000 to start building your <span style="color:#1672b5"><b>credit</b></span> Today!</h1>-->

                            </div>
                       
                             
                        </div><!-- card-body -->
                    </div><!-- card -->
                </div>
            </div><!-- row -->
        </div>

        <!-- footer -->
     <!--   <div class="what_do">
            <div class="container">
                <h1 class="text-uppercase text-center"><b><span style="color:#1672b5">what</span></b> we do for you!</h1>
                <h1 class="text-uppercase text-center">as you make your payments on time, we report your payment activity<br> to</h1>
                <h1 class="text-uppercase text-center">all three major <span style="color:#1672b5"><b>credit</b></span> bureaus</h1>
    
                <div  class="col-md-12 col-lg-12 col-sm-12 col-xl-12 credit-bg">
                   <img src="{{asset('homeassets/images/bureaus.png')}}" alt="" class="credit_bureaus">
                </div>
            </div>
        </div> -->
    <!-- end clients -->
    <!-- contact -->
    <!-- end contact -->
    <!-- footer -->
 @include('home.footer-content')
    @include('footer')