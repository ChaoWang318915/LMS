@extends('backend.layouts.app')


@section('content')
<body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<div class="container-fluid">
    <div class="card">
        <div class="card-header">
        
</button></h3> @if (Session::has('success'))
                      <div class="alert alert-danger text-center">
                          <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                          <p>{{ Session::get('success') }}</p>
                      </div>
                  @endif
                  
                  
                  @if(isset($message) && $message !='')
                  
                      <div class="alert alert-alert text-center" style="background-color: #da5858;color: white;font-size: 20px;">
                          <a href="#" class="close" data-dismiss="alert" aria-label="close" >×</a>
                          <p>{{ $message }}</p>
                      </div>
                     @endif
                      
                 
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                   
                            <div class="card wallet_card">
                                <div class="card-header bg-primary"><h5 class="text-center">Wallet</h5> <div class="float-right"></div></div>
                                <div class="card-body">
                                    <h3 class="text-center">
                                        <small style="color:#00adff">Available Credit:</small> 
                                            $<?php echo number_format($transwalletData[0]->total_credit,2)?> 
                                        <small style="color:#00adff">Balance:</small>
                                            ${{number_format($balance,2)}} 
                                    </h3>
                                </div>
                            </div>
                        </div>
                       <div class="col-md-6" >
                            <div class="card  status_card">
                                <div class="card-header bg-primary"><h5 class="text-center">Affiliate</h5></div>
                                <div class="card-body">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                               <th>Clicks</th>
                                               <th>Unique</th>
                                               <th>Referrals</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                           
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <strong>Share Link:</strong>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" id="link" class="form-control" value="http://dclcredit.com/?r={{auth()->user()->id}}">
                                        </div>
                                        <div class="col-md-3">
                                            <button class="form-control btn-primary btn-block" id="copy_link_btn">Copy</button>
                                        </div>
                                    </div>
                                     
                                </div>
                            </div>
                       </div>
                       <div class="col-md-4"></div>
                   </div>
                </div>
            </div>
        </div>
        </div>
        </div>
        
        <div>
        </div>
     

        <div class="container">
        <div class="col-md-12">
        <div class="card invoice_card">
        <div class="card-header bg-primary"><h5 class="text-center ">Recent Transactions</h5></div>
        
        <div class="card-body ">
        
      <table class="table">
      <thead>
      <tr>
    <th>Course Name</th>
     <th>Price</th>
     <th>Purchase Date</th>
     <th>Billing Date</th>
     
   
    </tr>
      </thead>

      <tbody>
      <tr>
        
        @if(isset($coursecbilling) && $coursecbilling !=='' )
      @foreach($coursecbilling as $data)
      <td>{{$data->course_name}}</td>
      <td>${{$data->price}}.00</td>
      <td><span class="badge badge-success">{{$data->purchase_date}}</span></td>
      <td><span class="badge badge-primary">{{$data->billing_date}}</span></td>
     
     
      </tr>
      @endforeach
      <td></td>
      <td></td>
      <td></td>
      <td></td>
     
      @else

    @endif
      </tbody>
      </table>
 
        </div>
        </div>
        
        </div>
        </div>
        </div>

        </div>
    </div>


<script>
  
    $('#copy_link_btn').click(function(){
        $('#link').select();      
        document.execCommand("copy");
    });
</script>
</body>



@stop


