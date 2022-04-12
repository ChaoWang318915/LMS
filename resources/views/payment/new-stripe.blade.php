@extends('backend.layouts.app')
@section('content')
@if (Session::has('success'))
      <div class="alert alert-success text-center">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
          <p>{{ Session::get('success') }}</p>
      </div>
  @endif
<!--<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<div class="container">
    <div class="col-md-12">
        <div class="card"  style="overflow:scroll;min-width:300px;">
            <h4 class="card-header">Make A Payment</h4>
           
            <div class="card-body">
                <!--<h4 class="card-title">Payment History</h4>-->
                <div class="card-header bg-primary"><h5 class="text-center ">Recent Payment History</h5></div>
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Amount</th>
                                    <th>Payment Date</th>
                                    <th>Status</th>
                                    <th>Reference#</th>
                                </tr>
                            </thead>  
                            <tbody>
                                @foreach($histories as $history)
                                <tr>
                                    <td>
                                        ${{number_format($history->amount,2)}}
                                    </td>
                                    <td>{{$history->payment_date}}</td>
                                    <td>Paid</td>
                                    <td>{{$history->reference}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
           
            <div class="card-body">
                @if(!session()->has('message'))
                <h4 class="card-title">Amount of Payment</h4>
                 
                <form method="post" action="{{route('stripe.checkmethod')}}">
                    @csrf
                    <div class="row">
                        <div class="col-md-3">
                           <div class="card">
                               <p style="text-align:center" class="mt-3"><strong>Minimum Due</strong></p>
                               <div class="row">
                                   <div class="col-md-2"></div>
                                   <div style="text-align:center" class="col-md-8">
                                       <label><input name="pay_option" value="1" {{ old('pay_option') == 1 ? 'checked' : ''}} type="radio"><p><strong> ${{number_format($minimal_balance,2)}}</strong></p></label>
                                       <input type="hidden" value="{{$minimal_balance}}" name="min_amount"></label>
                                   </div>
                                   <div class="col-md-2"></div>
                               </div>
                               <p></p>
                           </div>
                        </div>
                        <div class="col-md-3">
                           <div class="card">
                               <p style="text-align:center" class="mt-3"><strong>Other Amount $</strong></p>
                               <div class="row">
                                   <div class="col-md-2"></div>
                                   <div style="text-align:center" class="col-md-8">
                                       <label><input type="radio" name="pay_option" value="2" {{ old('pay_option') == 2 ? 'checked' : ''}}>
                                       <input type="number" min="{{$minimal_balance}}" step="0.01" class="form-control" name="amount"></label>
                                   </div>
                                   
                                   <div class="col-md-2"></div>
                               </div>
                               <p></p>
                           </div>
                        </div>
                        <div class="col-md-3">
                           <div class="card">
                               <p style="text-align:center" class="mt-3"><strong>Current Balance</strong></p>
                               <div class="row">
                                   <div class="col-md-2"></div>
                                   <div style="text-align:center" class="col-md-8">
                                       <label><input name="pay_option"  value="3" {{ old('pay_option') == 3 ? 'checked' : ''}} type="radio"><p><strong> ${{number_format($current_balance,2)}}</strong></p></label>
                                       <input type="hidden" name="current_balance" value="{{$last_balance}}">
                                   </div>
                                   <div class="col-md-2"></div>
                               </div>
                               <p></p>
                           </div>
                            
                        </div>
                        <div class="col-md-3">
                           <div class="card">
                               <p style="text-align:center" class="mt-3"><strong>Last Statement Balance</strong></p>
                               <div class="row">
                                   <div class="col-md-2"></div>
                                   <div style="text-align:center" class="col-md-8">
                                       <label><input name="pay_option" value="4" {{ old('pay_option') == 4 ? 'checked' : ''}} type="radio"><p><strong> ${{number_format($last_balance,2)}}</strong></p></label>
                                       <input type="hidden" name="last_balance" value="{{$current_balance}}">
                                   </div>
                                   <div class="col-md-2"></div>
                               </div>
                               <p></p>
                           </div>
                        </div>
                    </div>
                    <button class="btn btn-primary btn-lg btn-block" type="submit">Select Amount of Payment</button>
                </form>
                @else   
                    <h4 class="card-title">Enter Credit Card Information</h4>
                    <div class='form-row row'>
                        <div class="col-md-4"></div>
                        <div class='col-md-4 form-group'>
                            <img class="img-responsive" src="{{asset('assets/img/logo/cards.jpg')}}">
                        </div>
                        <div class="col-md-4"></div>
                    </div>
                  
                    <form role="form" action="/make_payment" method="post" class="require-validation"   data-cc-on-file="false"  data-stripe-publishable-key="{{ env('STRIPE_KEY') }}"  id="payment-form">                        
                        @csrf
                        <input type="hidden" name="amount" value="{{session()->get('message')}}">
                        <div class='form-row row'>
                            <div class='col-md-12 form-group required'>
                                <label class='control-label'>Name on Card</label> <input class='form-control' size='4' type='text'>
                            </div>
                        </div>
                        <div class='form-row row'>
                            <div class='col-md-12 form-group  required'>
                                <label class='control-label'>Card Number</label> <input autocomplete='off' class='form-control card-number' size='20' type='text'>
                            </div>
                        </div>
                        <div class='form-row row'>
                            <div class='col-xs-12 col-md-4 form-group cvc required'>
                                <label class='control-label'>CVC</label> <input autocomplete='off' class='form-control card-cvc' placeholder='ex. 311' size='4' type='text'>
                            </div>
                            <div class='col-xs-12 col-md-4 form-group expiration required'>
                                  <label class='control-label'>Expiration Month</label> <input class='form-control card-expiry-month' placeholder='MM' size='2' type='text'>
                              </div>
                            <div class='col-xs-12 col-md-4 form-group expiration required'>
                                <label class='control-label'>Expiration Year</label> <input class='form-control card-expiry-year' placeholder='YYYY' size='4' type='text'>
                            </div>
                        </div>
                        <div class='form-row row'>
                            <div class='col-md-12 error form-group hide'>
                                  <div class=' alert text-danger'></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <button class="btn btn-primary btn-lg btn-block" type="submit">Pay Now ${{session()->get('message')}}</button>
                            </div>
                        </div>
                    </form>
                @endif
               
            </div>
            
        </div>
       
    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
      
    <script type="text/javascript">
    $(function() {
        var $form  = $(".require-validation");
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
</div>
</div>
@endsection