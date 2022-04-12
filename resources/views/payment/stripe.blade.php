@extends('backend.layouts.app')
@section('content')

   <body>
   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
     <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
   

     <div class="container-fluid">
        
        <div class="card">
         <div class="card-body">
         <div class="row">
             
         <div class="col-md-4">
                   
                   <div class="card wallet_card">
                   <div class="card-header bg-primary"><h5 class="text-center">Pay</h5> <div class="float-right"></div></div>
                   <div class="card-body">
                   <img class="img-responsive" src="{{asset('assets/img/logo/cards.jpg')}}">
                  @if (Session::has('success'))
                      <div class="alert alert-success text-center">
                          <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                          <p>{{ Session::get('success') }}</p>
                      </div>
                  @endif
                   
               @if(isset($total_payment) && $total_payment != '')
                  <form role="form" action="/stripe_post/{{$total_payment}}" method="post" class="require-validation"
                
                  
                                                   data-cc-on-file="false"
                                                  data-stripe-publishable-key="{{ env('STRIPE_KEY') }}"
                                                  id="payment-form">

                          @else
                          <form role="form" action="/stripe_post/{{$generatePayment}}" method="post" class="require-validation"
                
                  
                    data-cc-on-file="false"
                    data-stripe-publishable-key="{{ env('STRIPE_KEY') }}"
                    id="payment-form">                        
                        
                         @endif

                      @csrf

                     

                      <div class='form-row row'>
                          <div class='col-md-12 form-group required'>
                              <label class='control-label'>Name on Card</label> <input
                                  class='form-control' size='4' type='text'>
                          </div>
                      </div>

                      <div class='form-row row'>
                          <div class='col-md-12 form-group  required'>
                              <label class='control-label'>Card Number</label> <input
                                  autocomplete='off' class='form-control card-number' size='20'
                                  type='text'>
                          </div>
                      </div>

                      
                      <div class='form-row row'>
                          <div class='col-xs-12 col-md-4 form-group cvc required'>
                              <label class='control-label'>CVC</label> <input autocomplete='off'
                                  class='form-control card-cvc' placeholder='ex. 311' size='4'
                                  type='text'>
                          </div>
                          <div class='col-xs-12 col-md-4 form-group expiration required'>
                              <label class='control-label'>Expiration Month</label> <input
                                  class='form-control card-expiry-month' placeholder='MM' size='2'
                                  type='text'>
                          </div>
                          <div class='col-xs-12 col-md-4 form-group expiration required'>
                              <label class='control-label'>Expiration Year</label> <input
                                  class='form-control card-expiry-year' placeholder='YYYY' size='4'
                                  type='text'>
                          </div>
                      </div>

                      <div class='form-row row'>
                          <div class='col-md-12 error form-group hide'>
                              <div class=' alert text-danger'></div>
                          </div>
                      </div>

                      <div class="row">
                          <div class="col-md-12">
                          @if(isset($total_payment) && $total_payment != '')
                              <button class="btn btn-primary btn-lg btn-block" type="submit">Pay Now {{$total_payment}}</button>
                              @else
                              <button class="btn btn-primary btn-lg btn-block" type="submit">Pay Now</button>
                              @endif
                          </div>
                      </div>
                        
                  </form>
              </div>
                   </div>
                   </div>
                  <div class="card  status_card">
                   <div class="card-header bg-primary"><h5 class="text-center">My Bill</h5></div>
                   <div class="card-body">
                 <table class="table">
                  
                   <thead>
                   
                   
                   <tr>
                 <td> Monthly Course Payment</td>
              
                  @if(isset($monthly_due) && $monthly_due != '')
                             <td>${{$monthly_due}}</td>
                              @else
                  <td>0</td>
                  @endif
                   
                  
                  
                      </tr>

                      <tr>
                   <td>Monthly Interest</td>
                   
                 @if(isset($total_amount_interest) && $total_amount_interest != '')
                             <td>${{$total_amount_interest}}</td>
                              @else
                  <td>0</td>
                  @endif
                  
                 
                  
                      </tr>

                      
                      <tr>
                   <td>Monthly Membership</td>
                   
                    @if(isset($monthly_mebership) && $monthly_mebership != '')
                             <td>${{$monthly_mebership}}</td>
                              @else
                  <td>0</td>
                  @endif
                 
                   </tr>
                   
                   <tr style="
    background-color: #007bff;
    color: white;
    font-weight: 500;">
                       
                   <td>Total</td>
                   
                    @if(isset($total_payment) &&  $total_payment != '')
                             <td>${{ $total_payment}}</td>
                  @else
                  <td>0</td>
                  @endif
                 
                   </tr>
                   
                   
                   <tr style="
    background-color:#e44d4d;
    color: white;
    font-weight: 500;">
                       
                   <td>Due Date</td>
                   
                    @if(isset($due_date) &&  $due_date != '')
                             <td>{{$due_date->billing_date}}</td>
                  @else
                  <td>000-0-00</td>
                  @endif
                   
                    
                 
                   </tr>
                   </thead>
                   </table>
                   </div>
                   </div>
                   </div>
                   
                  
                   </div>

                </div>

        
        <div>
        </div>

   
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
  
<script type="text/javascript">
$(function() {
    var $form         = $(".require-validation");
  $('form.require-validation').bind('submit', function(e) {
    var $form         = $(".require-validation"),
        inputSelector = ['input[type=email]', 'input[type=password]',
                         'input[type=text]', 'input[type=file]',
                         'textarea'].join(', '),
        $inputs       = $form.find('.required').find(inputSelector),
        $errorMessage = $form.find('div.error'),
        valid         = true;
        $errorMessage.addClass('hide');
 
        $('.has-error').removeClass('has-error');
    $inputs.each(function(i, el) {
      var $input = $(el);
      if ($input.val() === '') {
        $input.parent().addClass('has-error');
        $errorMessage.removeClass('hide');
        e.preventDefault();
      }
    });
  
    if (!$form.data('cc-on-file')) {
      e.preventDefault();
      Stripe.setPublishableKey($form.data('stripe-publishable-key'));
      Stripe.createToken({
        number: $('.card-number').val(),
        cvc: $('.card-cvc').val(),
        exp_month: $('.card-expiry-month').val(),
        exp_year: $('.card-expiry-year').val()
      }, stripeResponseHandler);
    }
  
  });
  
  function stripeResponseHandler(status, response) {
        if (response.error) {
            $('.error')
                .removeClass('hide')
                .find('.alert')
                .text(response.error.message);
        } else {
            // token contains id, last4, and card type
            var token = response['id'];
            // insert the token into the form so it gets submitted to the server
            $form.find('input[type=text]').empty();
            $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
            $form.get(0).submit();
        }
    }
  
});
</script>
</body>


    </div>
  </div>
</div>
@stop