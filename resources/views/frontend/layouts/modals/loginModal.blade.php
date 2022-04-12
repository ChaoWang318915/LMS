<style>
    .modal-dialog {
        margin: 1.75em auto;
        min-height: calc(100vh - 60px);
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    #myModal .close {
        position: absolute;
        right: 0.3rem;
    }

    .g-recaptcha div {
        margin: auto;
    }

    .modal-body .contact_form input[type='radio'] {
        width: auto;
        height: auto;
    }
    .modal-body .contact_form textarea{
        background-color: #eeeeee;
        padding: 15px;
        border-radius: 4px;
        margin-bottom: 10px;
        width: 100%;
        border: none
    }

    @media (max-width: 768px) {
        .modal-dialog {
            min-height: calc(100vh - 20px);
        }

        #myModal .modal-body {
            padding: 15px;
        }
    }
   a.go-register.float-left.text-info.pl-0.new_user,.new_teacher,.already {
    color: #fff!important;
    background: #117a8b;
    margin-bottom: 10px;
    padding: 20px;
    text-align: center;
    width: 100%;
    font-weight: 600;
}
.new_teacher:hover,.already:hover{
    color:#fff!important;
}
a.text-info:focus, a.text-info:hover {
    color: #fff!important;
}
</style>

@if(!auth()->check())

    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">


                <!-- Modal Header -->
                <div class="modal-header backgroud-style">
                    
                   @if((request()->segment(1) == 'courses') ? 'active' : '' )
                     <div class="gradient-bg" style="margin-left:0;background: -webkit-gradient(linear, left top, right top, from(#01a6fd), color-stop(51%, #17d0cf), to(#01a6fd));"></div>
                     @else
                      <div class="gradient-bg"></div>
                @endif
                
                   
                    <div class="popup-logo">
                        <img src="{{asset("storage/logos/".config('logo_popup'))}}" alt="">
                    </div>
                    <div class="popup-text text-center">
                        <h2>@lang('labels.frontend.modal.my_account') </h2>
                        <!--<p>@lang('labels.frontend.modal.login_register')</p>-->
                        <p><b>LOGIN</b> to our Website</p>
                    </div>
                    
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>

                </div>

                                <!-- Modal body -->
                                <style>a.text-info:focus, a.text-info:hover {
                    color: #fff!important;
                }
                </style>
                <div class="modal-body">
                    <div class="tab-content">
                        <div class="tab-pane container active" id="login">

                            <span class="error-response text-danger"></span>
                            @if(Request::is('user_loginModel'))
              <div>  <span class="success-response text-success text-center" id="demo">Registration Successfull Plase login</span></div>
                @endif
                            <form class="contact_form" id="loginForm" action="{{route('frontend.auth.login.post')}}"
                                  method="POST" enctype="multipart/form-data">
                                <a href="/registration_user" class="go-register float-left text-info pl-0 new_user">
                                    @lang('labels.frontend.modal.new_user_note')
                                </a>
                                <div class="contact-info mb-2">
                                    {{ html()->email('email')
                                        ->class('form-control mb-0')
                                        ->placeholder(__('validation.attributes.frontend.email'))
                                        ->attribute('maxlength', 191)
                                        }}
                                    <span id="login-email-error" class="text-danger"></span>

                                </div>
                                <div class="contact-info mb-2">
                                    {{ html()->password('password')
                                                     ->class('form-control mb-0')
                                                     ->placeholder(__('validation.attributes.frontend.password'))
                                                    }}
                                    <span id="login-password-error" class="text-danger"></span>

                                    <a class="text-info p-0 d-block text-right my-2"
                                       href="{{ route('frontend.auth.password.reset') }}">@lang('labels.frontend.passwords.forgot_password')</a>

                                </div>

                                @if(config('access.captcha.registration'))
                                    <div class="contact-info mb-2 text-center">
                                        {!! Captcha::display() !!}
                                        {{ html()->hidden('captcha_status', 'true') }}
                                        <span id="login-captcha-error" class="text-danger"></span>

                                    </div><!--col-->
                                @endif

                                <div class="nws-button text-center white text-capitalize">
                                    <button type="submit"
                                            value="Submit">@lang('labels.frontend.modal.login_now')</button>
                                    
                                </div>

                            </form>

                            <div id="socialLinks" class="text-center">
                            </div>

                        </div>
                        <div class="tab-pane container fade" id="register">

                            <form id="registerForm" class="contact_form"
                                  action="#"
                                  method="post">
                                {!! csrf_field() !!}
                                <a href="#"
                                   class="go-login float-right text-info pr-0 already">@lang('labels.frontend.modal.already_user_note')</a>
                                  
                                
                                <!--<a href="{{ route('frontend.auth.teacher.register') }}"-->
                                <!--   class="fgo-register float-left text-info mt-2 new_teacher">-->
                                <!--    @lang('labels.teacher.teacher_register')-->
                                <!--</a>-->
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
                                        <!--<button id="registerButton" type="submit"-->
                                        <!--        value="Submit">@lang('labels.frontend.modal.register_now')</button>-->
                                       <a class="btn nws-button" style="background: linear-gradient(to right, #01a6fd 0%, #17d0cf 51%, #01a6fd 100%);
                                        background-size: 200% auto;
                                        -webkit-transition: background 1s ease-out;
                                        transition: background 1s ease-out;
                                        width: 100%;
                                        padding: 13px;
                                        margin-left: -16px;
                                        font-weight: bold;
                                        color: white" href="{{route('user_register')}}">@lang('labels.frontend.modal.register_now')</a>
                                    </div>
                                </div>


                                
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

@push('after-scripts')
    @if (session('openModel'))
        <script>
            $('#myModal').modal('show');
        </script>
    @endif


    @if(config('access.captcha.registration'))
        {!! Captcha::script() !!}
    @endif

    <script>
        $(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $(document).ready(function () {
                $(document).on('click', '.go-login', function () {
                    $('#register').removeClass('active').addClass('fade')
                    $('#login').addClass('active').removeClass('fade')

                });
                $(document).on('click', '.go-register', function () {
                    $('#login').removeClass('active').addClass('fade')
                    $('#register').addClass('active').removeClass('fade')
                });

                $(document).on('click', '#openLoginModal', function (e) {
                    $.ajax({
                        type: "GET",
                        url: "{{route('frontend.auth.login')}}",
                        success: function (response) {
                            $('#socialLinks').html(response.socialLinks)
                            $('#myModal').modal('show');
                        },
                    });
                });

                $('#loginForm').on('submit', function (e) {
                    e.preventDefault();

                    var $this = $(this);
                    $('.success-response').empty();
                    $('.error-response').empty();

                    $.ajax({
                        type: $this.attr('method'),
                        url: $this.attr('action'),
                        data: $this.serializeArray(),
                        dataType: $this.data('type'),
                        success: function (response) {
                            $('#login-email-error').empty();
                            $('#login-password-error').empty();
                            $('#login-captcha-error').empty();

                            if (response.errors) {
                                if (response.errors.email) {
                                    $('#login-email-error').html(response.errors.email[0]);
                                }
                                if (response.errors.password) {
                                    $('#login-password-error').html(response.errors.password[0]);
                                }

                                var captcha = "g-recaptcha-response";
                                if (response.errors[captcha]) {
                                    $('#login-captcha-error').html(response.errors[captcha][0]);
                                }
                            }
                            if (response.success) {
                                $('#loginForm')[0].reset();
                                if (response.redirect == 'back') {
                                    location.reload();
                                } else {
                                    window.location.href = "/wallet"
                                }
                            }
                        },
                        error: function (jqXHR) {
                            var response = $.parseJSON(jqXHR.responseText);
                            console.log(jqXHR)
                            if (response.message) {
                                $('#login').find('span.error-response').html(response.message)
                            }
                        }
                    });
                });

                $(document).on('submit','#registerForm', function (e) {
                    e.preventDefault();
                    console.log('he')
                    var $this = $(this);

                    $.ajax({
                        type: $this.attr('method'),
                        url: "{{  route('frontend.auth.register.post')}}",
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
                                $('.success-response').empty().html("@lang('labels.frontend.modal.registration_message')");
                            }
                             
                        }
                    });
                });
            });

        });
    </script>
@endpush
