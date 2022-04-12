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
    display:none;
}
.contact_form select{
    height:50px !important;
}
</style>
   @include('home.header-content')
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
                                <h1 class="text-uppercase text-center"><b><span style="color:#1672b5">Earn Commissions by Promoting Dotcom Lessons</span></b></h1>
                                <!--<h1 class="text-uppercase text-center">Simply Complete and submit your application now </h1>
                                <h1 class="text-uppercase text-center">You will receive up to $2000 to start building your <span style="color:#1672b5"><b>credit</b></span> Today!</h1>-->

                            </div>
                       
                            <form id="registerForm" class="contact_form"
                                  action="#"
                                  method="post">
                                {!! csrf_field() !!}
                                  <!-- <a href="{{ route('frontend.auth.teacher.register') }}"
                                   class="fgo-register float-left text-info mt-2 new_teacher">
                                    @lang('labels.teacher.teacher_register')
                                </a> -->
                                <input type="hidden" name="role" value="affiliate">
                                <div class="contact-info mb-2">
                                   <!-- <h3 class="">You can earn commissions when you share the link we provide you with. You’ll also have access to resources and tools to help you be successful.</h3>
                                    <center>Guaranteed Approval 
                                    • Credit Limits between $600-$5000 
                                    • No Interest Charges
                                    • Credit Limit Increases 
                                    • No Monthly Membership Fees                    
                                    • and more... </center>-->
                                   <center><h3 class="">Complete Affiliate Application Form</h3>
                                    Please Note: You Must Be A U.S. Resident and 18 years of age to Apply.</center> 
                                </div>
                                <div class="contact-info mb-2">
                                    {{ html()->text('first_name')
                                        ->class('form-control mb-0')
                                        ->placeholder(__('validation.attributes.frontend.first_name'))
                                        ->attribute('maxlength', 191) }}
                                    <span id="first-name-error" class="text-danger"></span>
                                </div>
                                
                                <div class="contact-info mb-2">
                                    {{ html()->text('last_name')
                                      ->class('form-control mb-0')
                                      ->placeholder(__('validation.attributes.frontend.last_name'))
                                      ->attribute('maxlength', 191) }}
                                    <span id="last-name-error" class="text-danger"></span>

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
                                    <span id="password-confirmation-error" class="text-danger"></span>
                                </div>
                                 
                                <div class="contact-info mb-2"> 
                                   <input type="text" class="form-control mb-0" id="phoneNumber"  maxlength="16" placeholder="Phone" value="" name="phone">
                                   <span id="phone-error" class="text-danger"></span>
                                </div>
                                <div class="contact-info mb-2"> 
                                   <input type="text" class="form-control mb-0" placeholder="Street Address" value="" name="address">
                                   <span id="address-error" class="text-danger"></span>
                                </div>
                                <div class="contact-info mb-2">
                                   <input type="text" class="form-control mb-0" placeholder="City" value="" name="city">
                                   <span id="city-error" class="text-danger"></span>
                                </div>
                                <div class="contact-info mb-2"> 
                                   <input type="text" class="form-control mb-0" placeholder="Zip Code" value="" name="pincode">
                                   <span id="pincode-error" class="text-danger"></span>
                                </div>
                                <div class="contact-info mb-2"> 
                                    <select class="form-control mb-2" name="state">
                                        <option value="">State</option>
                                        @foreach($states as $state)
                                        <option value="{{$state->name}}">{{$state->name}}</option>
                                        @endforeach
                                    </select>
                                    <span id="state-error" class="text-danger"></span>
                                </div>
                                <div class="contact-info mb-2"> 
                                   <input type="text" class="form-control mb-0" value="United States" name="country"
                                        placeholder="U.S. Residents only" disabled >
                                </div>
                                
                                <span style="color:#1672b5">( If you are a company, please fill in below</span>)
                                <div class="contact-info mb-2"> 
                                   <input type="text" class="form-control mb-0" placeholder="Company Name (Optional)" value="" name="company_name">
                                   <span id="company_name-error" class="text-danger"></span>
                                </div>
                                <div class="contact-info mb-2"> 
                                   <input placeholder="Enter your website address" class="form-control  mb-0" name="website_url" value="">
                                   <span id="website_url-error" class="text-danger"></span>
                                </div>
                                <div class="contact-info mb-2"> 
                                   <input class="form-control  mb-0" placeholder="Enter brief description of your website" type="text" name="description" value="">
                                   <span id="description-error" class="text-danger"></span>
                                </div>
                                <div class="contact-info mb-2"> 
                                    <select name="website_type" class="form-control">
                                        <option value="">Select Website Type</option>
                                        <option value="Application">Application</option>
                                        <option value="Blog">Blog</option>
                                        <option value="Comparison">Comparison</option>
                                        <option value="Content">Content</option>
                                        <option value="Domain Registrar">Domain Registrar</option>
                                        <option value="Forum">Forum</option>
                                        <option value="Incentive">Incentive</option>
                                        <option value="Other">Other</option>
                                        <option value="PPC">PPC</option>
                                        <option value="Portal">Portal</option>
                                        <option value="Voucher/Coupon">Voucher/Coupon</option>
                                    </select>
                                </div>
                                @if(empty($referral_id))
                               <!-- <div class="contact-info mb-2"> 
                                   <input type="text" class="form-control mb-0" placeholder="Promo Code" value="" name="promo_code">
                                </div>-->
                                @endif
                                @if(config('access.captcha.registration'))
                                    <div class="contact-info mt-3 text-center">
                                        {!! Captcha::display() !!}
                                        {{ html()->hidden('captcha_status', 'true')->id('captcha_status') }}
                                        <span id="captcha-error" class="text-danger"></span>
                                    </div> 
                                @endif
                               <?php $time = strtotime(date("Y/m/d"));
                                  $date = date("M d, Y", strtotime("+1 month", $time)); ?>
                                
                                   <div class="contact-info mb-2">
                                  <!-- 
                                Personal Credit Account Disclosure - You will receive a credit line of up to $2000 today and will not have to make your first monthly payment until <b><?php echo $date; ?></b>. Today You will receive 5 course credits valued at at $150 for only $99.99. A one-time account processing fee will also be deducted from your account today. In total, $129.99 will be deducted from your credit account today.
                                --></div>
                                 <label class="radio-inline mr-3 mb-0">
                                    <input type="checkbox" name="active" class="checkbox"> 
                                        By checking box, I agree that I am 18 years of age or older, I agree to the <a href="/affiliate-terms" target="_blank"><b>Affiliate Terms</b></a>, <a href="/term-and-conditions" target="_blank"><b>Term of Use</b></a> and <a href="/privacy-policy" target="_blank"><b>Privacy Policy</b></a> on this website. 
                                </label>
                               
                                <span id="active-error" class="text-danger"></span>
                                <div class="contact-info mb-2 mx-auto w-50 py-4">
                                    <div class="nws-button text-center white text-capitalize">
                                        <button id="registerButton" type="submit"
                                                value="Submit" class="btn-info text-white border-none" style="border:none;padding:9px 12px;border-radius:4px">Register Now</button>
                                    </div>
                                </div>
                                
                                <input type="hidden"  name="referral_id" value="{{$referral_id}}">
                                <input type="hidden"  name="site_name" value="{{$site_name}}">
                                <input type="hidden"  name="ip_address" value="{{$ip_address}}">
                            </form>
                            {{ html()->form()->close() }}
                        </div><!-- card-body -->
                    </div><!-- card -->
                </div>
            </div><!-- row -->
            
        </div>

        <!-- footer -->
        <!--<div class="what_do">
            <div class="container">
                <h1 class="text-uppercase text-center"><b><span style="color:#1672b5">what</span></b> we do for you!</h1>
                <h1 class="text-uppercase text-center">as you make your payments on time, we report your payment activity<br> to</h1>
                <h1 class="text-uppercase text-center">all three major <span style="color:#1672b5"><b>credit</b></span> bureaus</h1>
    
                <div  class="col-md-12 col-lg-12 col-sm-12 col-xl-12 credit-bg">
                   <img src="{{asset('homeassets/images/bureaus.png')}}" alt="" class="credit_bureaus">
                </div>
            </div>
        </div>-->
    <!-- end clients -->
    <!-- contact -->
    <!-- end contact -->
    <!-- footer -->
    @include('home.footer-content')
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
                
                
                $(document).on('submit','#registerForm', function (e) {
                  
                    e.preventDefault();
                    var $this = $(this);
                    console.log($this.attr('method'))
                    $.ajax({
                        type: $this.attr('method'),
                        url: "https://dotcomlessons.com/register",
                        data: $this.serializeArray(),
                        dataType: $this.data('type'),
                        success: function (data) {
                            $('#first-name-error').empty()
                            $('#last-name-error').empty()
                            $('#email-error').empty()
                            $('#password-error').empty()
                            $('#address-error').empty()
                            $('#city-error').empty()
                            $('#state-error').empty()
                            $('#pincode-error').empty()
                            $('#active-error').empty()
                            $('#phone-error').empty()
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
                                 
                                if (data.errors.phone) {
                                    $('#phone-error').html(data.errors.phone[0]);
                                }
                                
                                if (data.errors.address) {
                                    $('#address-error').html(data.errors.address[0]);
                                }
                                if (data.errors.city) {
                                    $('#city-error').html(data.errors.city[0]);
                                }
                                if (data.errors.pincode) {
                                    $('#pincode-error').html(data.errors.pincode[0]);
                                }
                                if (data.errors.state) {
                                    $('#state-error').html(data.errors.state[0]);
                                }
                                if (data.errors.country) {
                                    $('#country-error').html(data.errors.country[0]);
                                }
                                if (data.errors.active) {
                                    $('#active-error').html("You must agree with this.");
                                }
    
                                var captcha = "g-recaptcha-response";
                                if (data.errors[captcha]) {
                                    $('#captcha-error').html(data.errors[captcha][0]);
                                }
                            }
                            else  window.location.href = "https://dotcomlessons.com/welcome";
                            
                        }
                    });
                });
            
    </script>
    </section>
    @include('footer')