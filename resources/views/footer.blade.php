</footer>
    <!-- end footer -->
    
    <!-- Javascript files-->
    <script src="{{asset('homeassets/js/jquery.min.js')}}"></script>
    <script src="{{asset('homeassets/js/popper.min.js')}}"></script>
    <script src="{{asset('homeassets/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('homeassets/js/jquery-3.0.0.min.js')}}"></script>
    <script src="{{asset('homeassets/js/plugin.js')}}"></script>
    <!-- sidebar -->
    <script src="{{asset('homeassets/js/jquery.mCustomScrollbar.concat.min.js')}}"></script>
    <script src="{{asset('homeassets/js/custom.js')}}"></script>
    <!-- javascript -->
    <script src="{{asset('homeassets/js/owl.carousel.js')}}"></script>
    <script src="https:cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.js"></script>
    
    <script>
        $(document).ready(function() {
            $(".fancybox").fancybox({
                openEffect: "none",
                closeEffect: "none"
            });

            $(".zoom").hover(function() {

                $(this).addClass('transition');
            }, function() {

                $(this).removeClass('transition');
            });
        });
    </script>
</body>

</html>


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
                        url: "https://dotcomlessons.com/login",
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
                        url: "https://dotcomlessons.com/register",
                        data: $this.serializeArray(),
                        dataType: $this.data('type'),
                        beforeSend: function(){
                        $('#showloader').show();
                                },
                         complete: function(){
                         $('#showloader').hide();
                                      },
                        success: function (data) {
                            $('#first-name-error').empty()
                            $('#last-name-error').empty()
                            $('#email-error').empty()
                            $('#password-error').empty()
                            $('#captcha-error').empty()
                            
                            $('#social-security-number-error').empty()
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
                                
                                
                                if (data.errors.social_security_number) {
                                    $('#social-security-number-error').html(data.errors.social_security_number[0]);
                                }
                                

                                var captcha = "g-recaptcha-response";
                                if (data.errors[captcha]) {
                                    $('#captcha-error').html(data.errors[captcha][0]);
                                }
                            }
                          
                               
                            
                           if (data.success) {

if (data.success) {
$('#registerForm')[0].reset();
if (data.redirect == 'back') {
    location.reload();
} else {
    window.location.href = "/launchmodal"
    $('.success-response').empty().html("Registration Successful. Please LogIn");
}
}
}          
                             
                        }
                    });
                });
            });

        });
        
        
        @if(Request::is('launchmodal'))
        $(document).ready(function(){
        $("#myModal").modal('show');
    });
     @endif
     
     $('#showloader').hide();
    </script>