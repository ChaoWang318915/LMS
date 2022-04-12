@include('header')
@include('frontend.layouts.modals.loginModal')

    <!-- loader  -->
   <!-- <div class="loader_bg">
        <div class="loader"><img src="{{asset('homeassets/images/loading.gif')}}" alt="#" /></div>
    </div>-->
    <!-- end loader -->
    <!-- header -->
    <header>
        <style>
            .card{
                border-radius: 30px;
            }
            
            .lift {
              box-shadow: 0.5rem 0.15rem 1.75rem 0.5rem rgba(31, 45, 65, 0.15);
              -webkit-transition: box-shadow 0.15s ease-in-out, -webkit-transform 0.15s ease-in-out;
              transition: box-shadow 0.15s ease-in-out, -webkit-transform 0.15s ease-in-out;
              transition: transform 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
              transition: transform 0.15s ease-in-out, box-shadow 0.15s ease-in-out, -webkit-transform 0.15s ease-in-out;
            }
            
            
            .lift:hover {
              -webkit-transform: translateY(-0.3333333333rem);
              transform: translateY(-0.3333333333rem);
              box-shadow: 0 0.5rem 2rem 0 rgba(31, 45, 65, 0.25);
            }
            
            .lift:active {
              -webkit-transform: none;
              transform: none;
              box-shadow: 0 0.15rem 1.75rem 0 rgba(31, 45, 65, 0.15);
            }
            
            .lift-sm {
              box-shadow: 0 0.125rem 0.25rem 0 rgba(31, 45, 65, 0.2);
            }
            
            .lift-sm:hover {
              -webkit-transform: translateY(-0.1666666667rem);
              transform: translateY(-0.1666666667rem);
              box-shadow: 0 0.25rem 1rem 0 rgba(31, 45, 65, 0.25);
            }
            
            .lift-sm:active {
              -webkit-transform: none;
              transform: none;
              box-shadow: 0 0.125rem 0.25rem 0 rgba(31, 45, 65, 0.2);
            }
            
            .card.lift {
              text-decoration: none;
              color: inherit;
            }
            
            .start-btn {
                height: 50px;
                line-height: 52px;
                border-radius: 30px;
                display: inline-block;
                padding: 0px 25px;
            }
            .course_img{
                width:100%;
               
            }
        </style>
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
            <div class="container-fluid breadcrumb_header">
                <div class="row">
                    <div class="col-xl-5 col-lg-5 col-md-5 col-sm-5 logo_grid">
                        <div class="logo"><img src="{{asset('homeassets/images/logo.jpg')}}" alt=""></div>
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
                <div class="contaniner auto middle_area">
                    <div  class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                        <div class="row">
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 middle_seca">
                                <div class="d-flex flex-column bd-highlight mb-3">
                                    <div class="p-2 bd-highlight"><h1 class="text-uppercase text-center text-white">Finance Your Online Courses<br> <span style="margin-left: -6px;">with <img src="{{asset('homeassets/images/dotcom.png')}}" alt="" height="150" width="150" style="margin-left:-11px; margin-top:-6px;"> <img src="{{asset('homeassets/images/lessons.png')}}" alt="" height="150" width="150" class="lessons"></span><br><span style="margin-left: -6px;">Simply Apply today.</span></h1></div>
                                      <div class="p-2 bd-highlight"><h3 class="text-uppercase text-center text-white">~ Instant Approval<br></h3></div>
                                      <div class="p-2 bd-highlight"></b><h3 class="text-uppercase text-center text-white"><b></b>~ No Interest Payments<b></b><br></h3></div>
                                      <div class="p-2 bd-highlight"><h3 class="text-uppercase text-center text-white">~ Low Monthly Payments<br></h3></div>
                                    <div class="p-2 bd-highlight"><h4 class="text-center text-white">It's easy to get started  ~ <span style="color:#ffc144">Open Your Account Today!</span><br><span class="gura"></span></h3></div>
                                    <div> <span><a href="/registration_user"> <button class="header_buuton offset-md-4"> START NOW </button></a></span></div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 middle_secb">
                                <div><iframe class="responsive-iframe youtoub" src="{{asset('homeassets/video/dotcom.mp4')}}" width="300" height="300"></iframe></div>
                            </div>
                        </div>
                    </div>
                </div>
             </div>
        </div>
     
        <!-- end header inner -->
    </header>
    <!-- end header -->
    <section class="slider_section">
       <div class="col-md-12 col-lg-12 col-sm-12 col-xl-12">
            <h1 class="text-uppercase text-center mt-5"><b>Build Your Credit History While You Learn</b> <br><span class="text-uppercase" style="color:#106cb2;font-weight:bold">How It Works</span></h1>
       </div>
    </section>
    <section class="slider_section">
       <div class="col-md-12 col-lg-12 col-sm-12 col-xl-12">
           <div class="container m-auto">
               <div class="row">
                   <div class="col-md-4 col-lg-4 col-sm-4 col-xs-4 mt-5">
                        <div class="number-img">
                            <img src="{{asset('/images/number-1.png')}}" style="float:left;width:15px;">
                        </div>
                        <div style="margin-left:45px;">
                            <span><strong>Simply Apply For a Dotcom Lessons Account.</strong><br>
                            No hard pull on your credit. We know how hard it is to establish good credit. We made it easy for you to get started.</span>
                        </div>
                   </div>
                   <div class="col-md-4 col-lg-4 col-sm-4 col-xs-4 mt-5">
                       <div class="number-img">
                            <img src="{{asset('/images/number-2.png')}}"  style="float:left;width:30px;">
                       </div>
                       <div style="margin-left:45px;">
                            <span><strong>You Will Receive a Credit Line.</strong><br>
                            You will receive a credit line today so you can purchase lessons on credit. This gives you an opportunity to pay off your purchases over time.</span>
                        </div>
                   </div>
                   <div class="col-md-4 col-lg-4 col-sm-4 col-xs-4 mt-5">
                       <div class="number-img">
                            <img src="{{asset('/images/number-3.png')}}"  style="float:left;width:30px;">
                        </div>
                       <div  style="margin-left:45px;">
                            <span><strong>Make Low Monthly Payments on Time.</strong><br>
                            Just Like a Credit Card, you can make your minimum payment every month to help you establish a good credit history. Your payments are reported to the credit bureaus.</span>
                        </div>
                   </div>
               </div>
           </div>
       </div>
    </section>
    <section class="slider_section">
        <div class="row">
            <div class="col-md-12 col-lg-12 col-sm-12 col-xl-12 mb-5">
                <h1 class="text-uppercase text-center mt-5">Open a personal <span class="text-uppercase" style="color:#106cb2;font-weight:bold">credit account</span> with us today!</h1>
            </div>
            <div class="col-md-12 col-lg-12 col-sm-12 col-xl-12 mb-5 text-center">
                <a class="start-btn gradient-bg text-center text-uppercase text-white font-weight-bold" href="{{route('user_register')}}">Get Started Today <i class="fas fa-caret-right"></i></a>
            </div>
       </div>
    </section>
    <section class="slider_section" style="background-color:rgb(0, 173, 238)">
        <div class="col-md-12 col-lg-12 col-sm-12 col-xl-12 mb-5">
            <div class="container m-auto">
                 <div class="row">
                    <div class="col-md-4 col-lg-4 col-sm-4 col-xl-4 mt-5" data-aos="fade-up">
                        <div class="card text-center text-decoration-none h-100 lift" href="#!">
                            <div class="card-body">
                                <div class="icon-stack icon-stack-lg bg-blue-soft text-blue mb-2">
                                    <img src="{{asset('/images/card.png')}}">
                                </div>
                                <h5><b>I Don’t Have Any Credit?</b></h5>
                                <p class="card-text">No Worries! Dotcom Lessons is designed to help beginners get started. We help you build a strong credit history.</p>
                                <a style="color:rgb(0, 173, 238);" class="text-center text-uppercase font-weight-bold" href="{{route('user_register')}}">Start Building Credit <i class="fas fa-caret-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-4 col-sm-4 col-xl-4 mt-5" data-aos="fade-up" data-aos-delay="100">
                        <div class="card text-center text-decoration-none h-100 lift" href="#!">
                            <div class="card-body">
                                <div class="icon-stack icon-stack-lg bg-blue-soft text-blue mb-2">
                                    <img src="{{asset('/images/dollar.png')}}">
                                </div>
                                <h5><b>I Don't Have Any Money?</b></h5>
                                <p class="card-text">
                                    Unlike other programs, you don't need any money to get started today. Your first payment is due in 30 days and you only have to pay the minimum of your outstanding balance every month. 
                                </p>
                                <a style="color:rgb(0, 173, 238);" class="text-center text-uppercase font-weight-bold" href="{{route('user_register')}}">Start Building Credit <i class="fas fa-caret-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-4 col-sm-4 col-xl-4 mt-5" data-aos="fade-up" data-aos-delay="150">
                        <div class="card text-center text-decoration-none h-100 lift" href="#!">
                            <div class="card-body">
                                <div class="icon-stack icon-stack-lg bg-blue-soft text-blue mb-2">
                                    <img src="{{asset('/images/compase.png')}}">
                                </div>
                                <h5><b>When Will My Credit Score Increase?</b></h5>
                                <p class="card-text">Every individual's credit profile is different. However the goal is to provide you with an easy system to help you build your credit</p>
                                <a style="color:rgb(0, 173, 238);" class="text-center text-uppercase font-weight-bold" href="{{route('user_register')}}">Start Building Credit <i class="fas fa-caret-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
       </div>
    </section>
    <section class="slider_section">
       <div class="col-md-12 col-lg-12 col-sm-12 col-xl-12">
           <h1 class="text-uppercase text-center mt-5" style="color:#106cb2"><b>3</b> Major Benefits of signing up with DotComLesssons Today:</h1>
       </div>

        <br>
        <div class="container m-auto">
            <div class="col-md-12 col-lg-12 col-sm-12 col-xl-12">
               <div class="row lift">
                   
                    <div class="col-md-6 col-lg-6 col-sm-6 col-xl-6">
                        <h2><b> </b></h2>
                        <h3><b> Benefit #1:</b></h3>
                        <p><span class="text-uppercase" style="color:#106cb2;font-weight:bold"> You Are APPROVED!</span> Sign up today and be approved for an instant line of credit of up to <span style="color:#16632b;font-weight:bold">$2,000.00</span> with the potential of increased credit lines <!--<span style="color:#16632b;font-weight:bold">$5,000.00 </span>-->after several months.</p>
                    </div>
                    <div class="col-md-6 col-lg-6 col-sm-6 col-xl-6  steps_grid1"></div>
              
                </div>
                
           </div>
            <br><br>
            <div class="col-md-12 col-lg-12 col-sm-12 col-xl-12">
                <div class="row lift">
                    <div class="col-md-6 col-lg-6 col-sm-6 col-xl-6">
                        <h3><b> Benefit #2:</b></h3>
                        <p><span class="text-uppercase" style="color:#106cb2;font-weight:bold">Improve Your Credit Score.</span> We report your payment history to the major credit bureaus. This is key in your credit building journey. The more positive items on your credit history , the more potential you have to receive better rates on car loans, mortgages and personal loans. </p>
                    </div>
                    <div class="col-md-6 col-lg-6 col-sm-6 col-xl-6 steps_grid2 "></div>
                </div>
            </div>
        <br><br>
      <div class="col-md-12 col-lg-12 col-sm-12 col-xl-12">
           <div class="row lift">
          <div class="col-md-6 col-lg-6 col-sm-6 col-xl-6">
            <h3><b> Benefit #3:</b></h3>
            <p><span class="text-uppercase" style="color:#106cb2;font-weight:bold">Unsecured Credit.</span> We know that getting started or re-establishing your credit can be hard.  So we do not require you to make a deposit. We give you an unsecured line of credit from the start. </p>
       
       </div>
       
       
       <div class="col-md-6 col-lg-6 col-sm-6 col-xl-6 steps_grid3"></div>
       </div>
       </div>
       </div>
       <br><br>
         <div class="col-md-12 col-lg-12 col-sm-12 col-xl-12 mb-5 text-center">
                <a class="start-btn gradient-bg text-center text-uppercase text-white font-weight-bold" href="{{route('user_register')}}">Get Started Today <i class="fas fa-caret-right"></i></a>
            </div>
    </section>
    <section class="slider_section" style="background-color:rgb(0, 173, 238)">
        <div class="container m-auto">
             <div class="row">
                <div class="col-md-12 col-lg-12 col-sm-12 col-xl-12 mt-5 mb-5 text-center">
                    <h1 class="text-white"><b>New COURSES/LESSONS are added EVERY WEEK</b></h1>
                </div>
            </div>
        </div>
    </section>
    <section class="slider_section">
        <div class="container m-auto">
            <div class="row">
                <div class="col-md-12 col-lg-12 col-sm-12 col-xl-12 mt-3 mb-3 text-center">
                    <h1><b>The Latest 5 Courses added to Dotcom Lessons</b></h1>
                </div>
            </div>
             <div class="row">
                <div class="col-md-12 col-lg-12 col-sm-12 col-xl-12">
                    <div class="course-list-view">
                        <table>
                            @foreach($courses as $course)
                                <tr>
                                    <td>
                                        <div class="row lift  mt-3 mb-3">
                                            <div class="col-sm-6 col-lg-6 col-xl-6 col-md-6 ">
                                                <img src="{{asset('storage/uploads/'.$course->course_image)}}" class="course_img">
                                            </div>
                                            <div class="col-sm-6 col-lg-6 col-xl-6 col-md-6">
                                                <div class="row">
                                                    <div class="col-sm-12 col-lg-12 col-xl-12 col-md-12">
                                                        <h1><b>{{$course->title}}</b></h1></a>  
                                                        <p>{{$course->description}}</p>
                                                    </div>
                                                    <div class="col-sm-12 col-lg-12 col-xl-12 col-md-12 text-center mb-2">
                                                        <div class="course-side-bar-widget">
                                                            <h3>Price: <span>${{number_format($course->price,2)}}</span></h3>
                                                        </div>
                                                        <form action="{{ route('cart.checkout') }}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="course_id" value="{{ $course->id }}"/>
                                                            <input type="hidden" name="amount" value="{{($course->free == 1) ? 0 : $course->price}}"/>
                                                            <button class="start-btn gradient-bg text-center text-uppercase text-white font-weight-bold"
                                                                    href="#">@lang('labels.frontend.course.buy_now') <i
                                                                        class="fas fa-caret-right"></i></button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 col-lg-12 col-sm-12 col-xl-12 mt-3 mb-3 text-center">
                     <a class="start-btn gradient-bg text-center text-uppercase text-white font-weight-bold" href="{{route('courses.all')}}">View More Courses <i class="fas fa-caret-right"></i></a>
                </div>
            </div>
        </div>
    </section>
    <section class="slider_section" style="background-color:rgb(0, 173, 238)">
        <div class="container m-auto">
             <div class="row">
                <div class="col-md-12 col-lg-12 col-sm-12 col-xl-12 mt-5 mb-5 text-center">
                    <h1 class="text-white"><b>Why Get Started Today?</b></h1>
                </div>
            </div>
        </div>
    </section>
      
    <section class="slider_section">
      
        <div class="container m-auto">
              <div class="col-md-12 col-lg-12 col-sm-12 col-xl-12 mt-3 mb-3 text-center">
                    <h1><b>Limited Time Special Offer!</b></h1>
                </div>
            <div class="course-list-view mt-5 mb-5">
                <table>
                    
                    <tbody>
                        <tr>
                            <td>
                         
                                <div class="row lift">
                                <div class="col-md-12 col-lg-12 col-sm-12 col-xl-12 text-center">
                                        
                                        <p><h2><b>Savings</b> and <b>Discounts</b> are what you will get when you <u>open your account today.</u> </h2></p>
                                    </div>
                                    <div class="col-md-6 col-lg-6 col-sm-6 col-xl-6 mt-5">
                                        <img src="{{asset('/images/start_image.jpg')}}">
                                       <br><br>
                                         <span><strong style="color:rgb(255,0, 0)" >Pay Nothing for 30 Days  </strong> - You can evaluate our system before your first payment is due. At that time you can decide to make the minimum payment or pay off your balance. We offer interest free credit loans, so you repay the same amount either way. <b>You save $269 just by getting started today!</b></span>
                                             <br><br>  
                                    </div>
                                    <div class="col-md-6 col-lg-6 col-sm-6 col-xl-6 mt-5">
                                        <div class="row">
                                       
                                            <div class="col-md-12 col-lg-12 col-sm-12 col-xl-12 mb-4">
                                                <div class="number-img">
                                                    <img src="{{asset('/images/check_img.png')}}" style="float:left;">
                                                </div>
                                                <div style="margin-left:40px;">
                                                    <span><strong>FREE one year membership - </strong>We know how hard it is to get started when it comes to building your credit. So your first year membership is free (<strike>$99</strike>)   </span>
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-lg-12 col-sm-12 col-xl-12 mb-4">
                                                <div class="number-img">
                                                    <img src="{{asset('/images/check_img.png')}}" style="float:left;">
                                                </div>
                                                <div style="margin-left:40px;">
                                                    <span><strong>FREE Credit Report Evaluation - </strong>As a new member of Dotcom Lessons, you are offered a free credit report evaluation to help you develop an action plan for your credit success. You are also offered a monthly discount on credit buildling services if you choose to use our repair services. $50 Value. <b>FREE TODAY!</b> </span>
                                                </div>
                                            </div>
                                          
                                                 <div class="col-md-12 col-lg-12 col-sm-12 col-xl-12 mb-4">
                                                <div class="number-img">
                                                    <img src="{{asset('/images/check_img.png')}}" style="float:left;">
                                                </div>
                                                <div style="margin-left:40px;">
                                                    <span><strong>$50 OFF on 5 Courses - </strong> 5 courses at $30 each cost $150. Today you will receive 5 credits which can be used at anytime for only $99.99 </span>
                                                </div>
                                            </div>
                                                <div class="col-md-12 col-lg-12 col-sm-12 col-xl-12 mb-4">
                                                <div class="number-img">
                                                    <img src="{{asset('/images/check_img.png')}}" style="float:left;">
                                                </div>
                                                <div style="margin-left:40px;">
                                                    <span><strong>$70 OFF Unsecured Credit Processing Fee - </strong> Our account set up processing fee covers verification and filing cost. Today this fee will only cost  <strike style="color:rgb(255,0, 0)">$100</strike> $30. <b>LIMITED TIME SPECIAL!<b></b></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-lg-12 col-sm-12 col-xl-12 text-center" style="background-color:rgb(230,234, 237)">
                                        
                                        <p style="color:#ff0000;"><h2>Today you will get a credit line up to $2000 to make purchases on any of our online courses.
                                        You will get a <b>$269 </b><u>limited time special offer</u> discount (<strike style="color:rgb(252, 0, 0)">$399</strike> <b>$129.99</b>) when starting today.<br> <br>
                                    
                                    If for any reason before 30 days when your first payment is due, you would like to close your account, simply cancel and <b>PAY NOTHING.</b> 
                                        However, if you enjoy all of the benefits we offer you, simply follow our system that will help you increase your credit. </h2></p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
           <div class="col-md-12 col-lg-12 col-sm-12 col-xl-12 mb-5 text-center">
                <a class="start-btn gradient-bg text-center text-uppercase text-white font-weight-bold" href="{{route('user_register')}}">Get Started Today <i class="fas fa-caret-right"></i></a>
            </div>
        
    </section>
   <!--    <section class="slider_section" style="background-color:rgb(255, 174, 0)">
        <div class="container m-auto">
             <div class="row">
                <div class="col-md-12 col-lg-12 col-sm-12 col-xl-12 mt-5 mb-5 text-center">
                    <h1 class="text-white"><b>HERE IS WHAT YOU GET TODAY</b></h1>
                    <h1 class="text-white"><b>LIMITED TIME SPECIAL OFFER!</b></h1>
                </div>
            </div>
        </div>
    </section>
    <section class="slider_section">
        <div class="container m-auto">
            <div class="course-list-view mt-5 mb-5">
                <table>
                    <tbody>
                        <tr>
                            <td>
                                <div class="row lift">
                                    <div class="col-md-6 col-lg-6 col-sm-6 col-xl-6 mt-5">
                                        <img src="{{asset('/images/start_image.jpg')}}">
                                    </div>
                                    <div class="col-md-6 col-lg-6 col-sm-6 col-xl-6 mt-5">
                                        <div class="row">
                                            <div class="col-md-12 col-lg-12 col-sm-12 col-xl-12 mb-4">
                                                <div class="number-img">
                                                    <img src="{{asset('/images/check_img.png')}}" style="float:left;">
                                                </div>
                                                <div style="margin-left:40px;">
                                                    <span><strong>Integrate - </strong> Share data with anyone with just a few clicks of the mouse.</span>
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-lg-12 col-sm-12 col-xl-12 mb-4">
                                                <div class="number-img">
                                                    <img src="{{asset('/images/check_img.png')}}" style="float:left;">
                                                </div>
                                                <div style="margin-left:40px;">
                                                    <span><strong>Automate - </strong> Transfer information from between several apps with workflows.</span>
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-lg-12 col-sm-12 col-xl-12 mb-4">
                                                <div class="number-img">
                                                    <img src="{{asset('/images/check_img.png')}}" style="float:left;">
                                                </div>
                                                <div style="margin-left:40px;">
                                                    <span><strong>Innovate - </strong> No code required. Create processes in a few clicks.</span>
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-lg-12 col-sm-12 col-xl-12 mb-4">
                                                <div class="number-img">
                                                    <img src="{{asset('/images/check_img.png')}}" style="float:left;">
                                                </div>
                                                <div style="margin-left:40px;">
                                                    <span><strong>Action - </strong> That's what it is. You get things done without your intervention.</span>
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-lg-12 col-sm-12 col-xl-12 mb-4">
                                                <div class="number-img">
                                                    <img src="{{asset('/images/check_img.png')}}" style="float:left;">
                                                </div>
                                                <div style="margin-left:40px;">
                                                    <span><strong>Happiness - </strong> Millions of people rely on Zapier to handle their daily tedious tasks.</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-lg-12 col-sm-12 col-xl-12">
                                        <p>And the list goes and on.</p>
                                        <p>There's no dobut that Zapier will help simplify your business life and that is why I decided to come up with this unique over the 
                                            shoulder video series  to get you started very quickly with it.</p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section> -->
    <!-- about -->
   
    </div>
    <!-- end about -->

 
    <div class="what_do">
        <div class="container">
            <h1 class="text-uppercase text-center"><b><span style="color:#000000">Not only do you receive all of these benefits, but you can also increase your knowledge and skills with our educational courses.<br><br> <span class="text-uppercase" style="color:#106cb2;font-weight:bold">What are you waiting for? Sign up today! </span></b></h1>
        <div class="col-md-12 col-lg-12 col-sm-12 col-xl-12 mb-5 text-center">
                <a class="start-btn gradient-bg text-center text-uppercase text-white font-weight-bold" href="{{route('user_register')}}">Get Started Today <i class="fas fa-caret-right"></i></a>
            </div>
      
      <!-- <h1 class="text-uppercase text-center">as you make your paymentson time, we report your payment activity<br> to</h1>-->
       <!-- <h1 class="text-uppercase text-center">all three major <span style="color:#1672b5"><b>credit</b></span> bureaus</h1> -->

      <!-- <div  class="col-md-12 col-lg-12 col-sm-12 col-xl-12 credit-bg">
           <img src="{{asset('homeassets/images/bureaus.png')}}" alt="" class="credit_bureaus">
       </div>-->
      </div>
    </div>
        <section class="slider_section" style="background-color:#302f2b">
        <div class="container m-auto">
            <div class="row">
                <div class="col-md-12 col-lg-12 col-sm-12 col-xl-12 text-center mt-5 mb-5">
                    <img src="{{asset('/images/lock.png')}}">
                    <h1 style="color:#0a9afa">Trusted Security</h1>
                    <p class="text-white">We use Strong SHA-2 and 2048-bit encryption.</p>
                </div>
            </div>
        </div>
    </section>
    <!-- end clients -->
    <!-- contact -->
    
    <!-- end contact -->

    <!-- footer -->
 @include('home.footer-content')

       @include('footer')