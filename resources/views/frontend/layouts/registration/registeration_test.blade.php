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
</i>
logout</button></a>

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
            <h1 class="text-uppercase text-center"><b><span style="color:#1672b5">YOU ARE APPROVED!</span></b></h1>
       <h1 class="text-uppercase text-center">Simply Complete and submit your application now </h1>
       <h1 class="text-uppercase text-center">You will receive up to $2000 to start building your <span style="color:#1672b5"><b>credit</b></span> Today!</h1>

      </div>
                       
                        <form id="registerForm" class="contact_form"
                                  action="#"
                                  method="post">
                                {!! csrf_field() !!}
                                
                                  <!-- <a href="{{ route('frontend.auth.teacher.register') }}"
                                   class="fgo-register float-left text-info mt-2 new_teacher">
                                    @lang('labels.teacher.teacher_register')
                                </a> -->
                                <div class="contact-info mb-2">

                                    <h3 class="">Here is what we offer to help you build or re-establish your credit history.</h3>
                                    Guaranteed Approval 
                                    • Credit Limits between $600-$5000 
                                    • APR 24.99% 
                                    • Credit Limit Increases 
                                    • Low Annual Fee                    
                                    • and more... 
                                    <h3 class="">Complete Application form</h3>


                                </div>
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
                                    <span id="suffix-name" class="text-danger"></span>
                                </div>
                                <div class="contact-info mb-2">
                                    {{ html()->text('last_name')
                                      ->class('form-control mb-0')
                                      ->placeholder(__('validation.attributes.frontend.last_name'))
                                      ->attribute('maxlength', 191) }}
                                    <span id="last-name-error" class="text-danger"></span>

                                </div>
                                <div class="contact-info mb-2">
                                    
                                    <select class="form-control mb-2" id="name_suffix" name="name_suffix" style="display:none;width:100%">
                                        <option value>Name Suffix</option>
                                        <option value="DDS">DDS</option>
                                        <option value="MD">MD</option>
                                        <option value="PHD">PHD</option>
                                        <option value="JR">JR</option>
                                        <option value="SR">SR</option>
                                        <option value="I">I</option>
                                        <option value="II">II</option>
                                        <option value="III">III</option>
                                        <option value="IV">IV</option>
                                        <option value="V">V</option>
                                        <option value="VI">VI</option>
                                    </select>
                                       
                                    <!--<span id="suffix-name-error" class="text-danger"></span>-->
                                </div>
                                
                               <div class="contact-info mb-2">
                                    <input type="text" class="form-control mb-0" id="social_security_number"  maxlength="15" placeholder="Social Security Number" value="" name="social_security_number">
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
                                <div class="contact-info mb-2"> 
                                   <input type="text" class="form-control mb-0" 
                                            onfocus="(this.type='date')" name="birthday" placeholder="Birthday">
                                </div>
                                <div class="contact-info mb-2"> 
                                   <input type="text" class="form-control mb-0" id="phoneNumber"  maxlength="16" placeholder="Phone" value="" name="phone">
                                </div>
                                <div class="contact-info mb-2"> 
                                   <input type="text" class="form-control mb-0" placeholder="Address" value="" name="address">
                                </div>
                                <div class="contact-info mb-2">
                                   <input type="text" class="form-control mb-0" placeholder="City" value="" name="city">
                                </div>
                                <div class="contact-info mb-2"> 
                                   <input type="text" class="form-control mb-0" placeholder="Zip Code" value="" name="pincode">
                                </div>
                                <div class="contact-info mb-2"> 
                                    <select class="form-control mb-2" name="state" style="display:none">
                                        <option value="">State</option>
                                        @foreach($states as $state)
                                        <option value="{{$state->name}}">{{$state->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="contact-info mb-2"> 
                                   <input type="text" class="form-control mb-0" value="United States" name="country"
                                                       placeholder="U.S. Residents only" disabled >
                                </div>
                                @if(config('access.captcha.registration'))
                                    <div class="contact-info mt-3 text-center">
                                        {!! Captcha::display() !!}
                                        {{ html()->hidden('captcha_status', 'true')->id('captcha_status') }}
                                        <span id="captcha-error" class="text-danger"></span>

                                    </div><!--col-->
                                @endif
                                <label class="radio-inline mr-3 mb-0">
                                    <input type="checkbox" name="active" class="checkbox" checked> 
                                        <a href="/term-and-conditions" target="_blank">By confirming this, I agree to the <b>Term of Use</b> and <b>Privacy Policy</b></a>
                                </label>

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
       <h1 class="text-uppercase text-center">as you make your payments on time, we report your payment activity<br> to</h1>
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
                                <li> <a href="#"><i class="fa fa-facebook"></i></a></li>

                            </ul>
                    </div>
                    
                    </div>
                    
                </div>
            </div>
        </div>
        <script>
                const isNumericInput = (event) => {
                    const key = event.keyCode;
                    return ((key >= 48 && key <= 57) || // Allow number line
                        (key >= 96 && key <= 105) // Allow number pad
                    );
                };
                
                const isModifierKey = (event) => {
                    const key = event.keyCode;
                    return (event.shiftKey === true || key === 35 || key === 36) || // Allow Shift, Home, End
                        (key === 8 || key === 9 || key === 13 || key === 46) || // Allow Backspace, Tab, Enter, Delete
                        (key > 36 && key < 41) || // Allow left, up, right, down
                        (
                            // Allow Ctrl/Command + A,C,V,X,Z
                            (event.ctrlKey === true || event.metaKey === true) &&
                            (key === 65 || key === 67 || key === 86 || key === 88 || key === 90)
                        )
                };
                
                const enforceFormat = (event) => {
                    // Input must be of a valid number format or a modifier key, and not longer than ten digits
                    if(!isNumericInput(event) && !isModifierKey(event)){
                        event.preventDefault();
                    }
                };
                
                const formatToPhone = (event) => {
                    if(isModifierKey(event)) {return;}
                
                    // I am lazy and don't like to type things more than once
                    const target = event.target;
                    const input = target.value.replace(/\D/g,'').substring(0,10); // First ten digits of input only
                    const areaCode = input.substring(0,3);
                    const middle = input.substring(3,6);
                    const last = input.substring(6,10);
                
                    if(input.length > 6){target.value = `(${areaCode}) ${middle} - ${last}`;}
                    else if(input.length > 3){target.value = `(${areaCode}) ${middle}`;}
                    else if(input.length > 0){target.value = `(${areaCode}`;}
                };
                
                const formatToSoicalNumber = (event) => {
                    if(isModifierKey(event)) {return;}
                
                    // I am lazy and don't like to type things more than once
                    const target = event.target;
                    const input = target.value.replace(/\D/g,'').substring(0,9); // First ten digits of input only
                    const areaCode = input.substring(0,3);
                    const middle = input.substring(3,5);
                    const last = input.substring(5,9);
                
                    if(input.length > 5){target.value = `${areaCode} - ${middle} - ${last}`;}
                    else if(input.length > 3){target.value = `${areaCode} - ${middle}`;}
                    else if(input.length > 0){target.value = `${areaCode}`;}
                };
                
                const inputElement = document.getElementById('phoneNumber');
                inputElement.addEventListener('keydown',enforceFormat);
                inputElement.addEventListener('keyup',formatToPhone);
                
                const inputSocialNumberElement = document.getElementById('social_security_number');
                inputSocialNumberElement.addEventListener('keydown',enforceFormat);
                inputSocialNumberElement.addEventListener('keyup',formatToSoicalNumber);
                
                

                $(document).on('submit','#registerForm', function (e) {
                    e.preventDefault();
                    console.log('he')
                    var $this = $(this);

                    $.ajax({
                        type: $this.attr('method'),
                        url: "http://lms.dotcomlessons.com/register",
                        data: $this.serializeArray(),
                        dataType: $this.data('type'),
                        success: function (data) {
                            $('#first-name-error').empty()
                            $('#last-name-error').empty()
                            $('#email-error').empty()
                            $('#password-error').empty()
                            $('#captcha-error').empty()
                            if (data.errors) {
                                if (data.errors.first_name) {
                                    $('#first-name-error').html(data.errors.first_name[0]);
                                }
                                if (data.errors.last_name) {
                                    $('#last-name-error').html(data.errors.last_name[0]);
                                }
                                if (data.errors.email) {
                                    $('#email-error').html(data.errors.email[0]);
                                }
                                if (data.errors.password) {
                                    $('#password-error').html(data.errors.password[0]);
                                }

                                var captcha = "g-recaptcha-response";
                                if (data.errors[captcha]) {
                                    $('#captcha-error').html(data.errors[captcha][0]);
                                }
                            }
                          
                               
                            
                            if (data.success) {
                                $('#registerForm')[0].reset();
                                $('#register').removeClass('active').addClass('fade')
                                $('.error-response').empty();
                                $('#login').addClass('active').removeClass('fade')
                                $('.success-response').empty().html("Registration Successful. Please LogIn");
                            }
                             
                        }
                    });
                });
          
    </script>
    </section>
    @include('footer')