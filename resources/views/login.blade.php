@include('header')
@include('frontend.layouts.modals.loginModal')

<header>
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 top_grid">

    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 offset-md-8">
       <a href="/registration_user"> <button class="top_grid_button_reg"><i class="fa fa-user" aria-hidden="true"></i>
register</button></a>
        <button class="top_grid_button_log" data-toggle="modal" data-target="#myModal"><i class="fa fa-sign-in" aria-hidden="true"></i>
        
Log In</button>

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
                                    
                                    </ul>
                                </nav>
                            </div>
                        </div>
                  </div>
            </div>
            
        
        <!-- end header inner -->
    </header>
     

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

                       
                        <form id="registerForm" class="contact_form"
                                  action="#"
                                  method="post">
                                {!! csrf_field() !!}
                                
                                   <a href="{{ route('frontend.auth.teacher.register') }}"
                                   class="fgo-register float-left text-info mt-2 new_teacher">
                                    @lang('labels.teacher.teacher_register')
                                </a>
                                <div class="contact-info mb-2">


                                    {{ html()->text('first_name')
                                        ->class('form-control mb-0')
                                        ->placeholder(__('validation.attributes.frontend.first_name'))
                                        ->attribute('maxlength', 191) }}
                                    <span id="first-name-error" class="text-danger"></span>
                                </div>
                                <div class="contact-info mb-2">

                           
                                    {{ html()->text('middle_name')
                                        ->class('form-control mb-0')
                                        ->placeholder(__('Middle Name'))
                                        ->attribute('maxlength', 191) }}
                                    <span id="suffix-name-error" class="text-danger"></span>
                                </div>
                                <div class="contact-info mb-2">
                                    {{ html()->text('last_name')
                                      ->class('form-control mb-0')
                                      ->placeholder(__('validation.attributes.frontend.last_name'))
                                      ->attribute('maxlength', 191) }}
                                    <span id="last-name-error" class="text-danger"></span>

                                </div>
                                <div class="contact-info mb-2">


                                    {{ html()->text('name_suffix')
                                        ->class('form-control mb-0')
                                        ->placeholder(__('Name Suffix'))
                                        ->attribute('maxlength', 191) }}
                                    <span id="suffix-name-error" class="text-danger"></span>
                                </div>
                               <div class="contact-info mb-2">


                                    {{ html()->text('social_security_number')
                                        ->class('form-control mb-0')
                                        ->placeholder(__('Social Security Number'))
                                        ->attribute('maxlength', 9) }}
                                    <span id="social-security-number-error" class="text-danger"></span>
                                </div>
                                <div class="contact-info mb-2">
                                    {{ html()->email('email')
                                       ->class('form-control mb-0')
                                       ->placeholder(__('validation.attributes.frontend.email'))
                                       ->attribute('maxlength', 191)
                                       }}
                                    <span id="email-error" class="text-danger"></span>

                                </div>
                                <div class="contact-info mb-2">
                                    {{ html()->password('password')
                                        ->class('form-control mb-0')
                                        ->placeholder(__('validation.attributes.frontend.password'))
                                         }}
                                    <span id="password-error" class="text-danger"></span>
                                </div>
                                <div class="contact-info mb-2">
                                    {{ html()->password('password_confirmation')
                                        ->class('form-control mb-0')
                                        ->placeholder(__('validation.attributes.frontend.password_confirmation'))
                                         }}
                                </div>
                                @if(config('registration_fields') != NULL)
                                    @php
                                        $fields = json_decode(config('registration_fields'));
                                        $inputs = ['text','number','date'];
                                    @endphp
                                    @foreach($fields as $item)
                                        @if(in_array($item->type,$inputs))
                                                @if($item->name=='country')
                                        <div class="contact-info mb-2 twewe">
                                                <input type="{{$item->type}}" class="form-control mb-0" value="United States" name="{{$item->name}}"
                                                       placeholder="U.S. Residents only" disabled >
                                            </div>
                                                    @endif
                                            @if($item->name!='country')
                                            <div class="contact-info mb-2">
                                                <input type="{{$item->type}}" class="form-control mb-0" value="{{old($item->name)}}" name="{{$item->name}}"
                                                       placeholder="{{__('labels.backend.general_settings.user_registration_settings.fields.'.$item->name)}}">
                                            </div>
                                            
                                            @endif
                                            
                                            
                                        @elseif($item->type == 'gender')
                                            <div class="contact-info mb-2">
                                                <label class="radio-inline mr-3 mb-0">
                                                    <input type="radio" name="{{$item->name}}" value="male"> {{__('validation.attributes.frontend.male')}}
                                                </label>
                                                <label class="radio-inline mr-3 mb-0">
                                                    <input type="radio" name="{{$item->name}}" value="female"> {{__('validation.attributes.frontend.female')}}
                                                </label>
                                                <label class="radio-inline mr-3 mb-0">
                                                    <input type="radio" name="{{$item->name}}" value="other"> {{__('validation.attributes.frontend.other')}}
                                                </label>
                                            </div>
                                        @elseif($item->type == 'textarea')
                                            <div class="contact-info mb-2">

                                            <textarea name="{{$item->name}}" placeholder="{{__('labels.backend.general_settings.user_registration_settings.fields.'.$item->name)}}" class="form-control mb-0">{{old($item->name)}}</textarea>
                                            </div>
                                        @endif
                                    @endforeach
                                @endif

                                @if(config('access.captcha.registration'))
                                    <div class="contact-info mt-3 text-center">
                                        {!! Captcha::display() !!}
                                        {{ html()->hidden('captcha_status', 'true')->id('captcha_status') }}
                                        <span id="captcha-error" class="text-danger"></span>

                                    </div><!--col-->
                                @endif
                                    <!--<label class="radio-inline mr-3 mb-0">-->
                                    <!--                <input type="checkbox" name="active" value="1" style="width: 10px!important;height: 10px!important;"> <a href="/term-and-conditions" target="_blank">By confirming this, I agree to the <b>Term of Use</b> and <b>Privacy Policy</b></a>-->
                                    <!--            </label>-->

                                <div class="contact-info mb-2 mx-auto w-50 py-4">
                                    <div class="nws-button text-center white text-capitalize">
                                        <button id="registerButton" type="submit"
                                                value="Submit" class="btn-info text-white border-none" style="border:none;padding:9px 12px;border-radius:4px">Register Now</button>
                                    </div>
                                </div>


                                
                            </form>
                            {{ html()->form()->close() }}
                        </div><!-- card-body -->
                    </div><!-- card -->
                </div>
            </div><!-- row -->
        </div>

        <!-- footer -->
        <div class="what_do">
        <div class="container">
            <h1 class="text-uppercase text-center"><b><span style="color:#1672b5">what</span></b> we do for you!</h1>
       <h1 class="text-uppercase text-center">as you make your paymentson time, we report your payment activity<br> to</h1>
       <h1 class="text-uppercase text-center">all three major <span style="color:#1672b5"><b>credit</b></span> bureaus</h1>

       <div  class="col-md-12 col-lg-12 col-sm-12 col-xl-12 credit-bg">
           <img src="{{asset('homeassets/images/bureaus.png')}}" alt="" class="credit_bureaus">
       </div>
      </div>
    </div>
    <!-- end clients -->
    <!-- contact -->
    
    <!-- end contact -->

    <!-- footer -->
    <footer>
        <div id="contact" class="footer">
            <div class="container">
                <div class="row pdn-top-30">
                    <div class="col-md-12 ">
                        <div class="footer-box">
                            <div class="headinga">
                                <h3>GET STARTED TODAY!</h3>
                                <span><a href="/courses"> <button class="footer_buuton">CLICK HERE</button></a></span>
                                
                            </div>
                           
                            
                        </div>
                    </div>
                </div>
            </div>
            <div class="copyright">
                   <div class="container">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                    <div class="row">
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6"><p>© 2021 dotcomlessons.com<a href="#"></a></p></div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                 <ul class="location_icon"><span style="padding-right:10px;color:white">Follow Us:</span> 
                                
                                <li> <a href="#"><i class="fa fa-twitter"></i></a></li>
                                <li> <a href="#"><i class="fa fa-instagram"></i></a></li>
                                <li> <a href="#"><i class="fa fa-linkedin"></i></a></li>
                                <li> <a href="#"><i class="fa fa-facebook-f"></i></a></li>

                            </ul>
                    </div>
                    
                    </div>
                    
                </div>
            </div>
        </div>
        
    </section>

    
    @include('footer')