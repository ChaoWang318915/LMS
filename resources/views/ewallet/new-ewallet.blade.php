@extends('backend.layouts.app')


@section('content')
<body>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <div class="container-fluid">
        <div class="card">
            
            <div class="card-header">
                <strong>@lang('strings.backend.dashboard.welcome') {{ $logged_in_user->first_name }} {{ $logged_in_user->last_name }} {{ $logged_in_user->name_suffix}}!</strong>
                @if($logged_in_user->verify_status == 1 && $logged_in_user->confirmed == 1 && $logged_in_user->payment == 1)<strong style="color:brown">( ACCOUNT VERIFIED )</strong>
                @else <strong style="color:brown">( ACCOUNT UNVERIFIED )</strong>@endif
                @if (Session::has('success'))
                
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
                            <div class="col-md-12">
                                {!! $dashboard->content !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                       
                                <div class="card wallet_card">
                                    <div class="card-header bg-primary">
                                        <h5 class="text-center">Wallet</h5> 
                                      
                                    </div>
                                    <div class="card-body">
                                        <h4>
                                            <small style="color:#00adff">Credit Line:</small> 
                                                ${{number_format($total_credit,2)}}
                                        </h4>
                                        <h4>
                                            <small style="color:#00adff">Available Credit:</small>
                                                ${{number_format($available_credit,2)}} 
                                        </h4>
                                        <h4>
                                            <small style="color:#00adff">Current Balance:</small>
                                              ${{number_format($current_balance,2)}}
                                        </h4>
                                        <h4>
                                            <small style="color:#00adff">Payment Due Date:</small> 
                                                {{$user->bill_date}}
                                        </h4>
                                    </div>
                                </div>
                            </div>
                           <div class="col-md-6" >
                                <div class="card  status_card" style="overflow:scroll;min-width:300px;">
                                    <div class="card-header bg-primary"><h5 class="text-center">Rewards Program</h5></div>
                                    <div class="card-body">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                   <th>Clicks</th>
                                                   <th>Unique</th>
                                                   <th>T1</th>
                                                   <th>T2</th>
                                                   <th>Commission</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                
                                                <tr>
                                                    <td>{{$user->clicks}}</td>
                                                    <td>{{$user->unique_clicks}}</td>
                                                    <td>{{$user->referral_cnt}}</td>
                                                    <td>{{$user->tier_2_cnt}}</td>
                                                    <td>${{number_format($user->commission,2)}}</td>
                                                </tr>
                                               
                                            </tbody>
                                        </table>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <strong>Share Link:</strong>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" id="link" class="form-control" value="http://dclcredit.com?r={{auth()->user()->id}}">
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
        
   <div class="container">
        <div class="col-md-12">
            <div class="card invoice_card"  style="overflow:scroll;min-width:300px;">
                <div class="card-header bg-primary"><h5 class="text-center ">Recent Transactions</h5></div>
                <div class="card-body ">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Course Name</th>
                                 <th>Price</th>
                                 <th>Purchase Date</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($courses as $course)
                            <tr>
                                <td>
                                    {{$course->course_name}}
                                </td>
                                <td>
                                    @if($course->card_status == 1)
                                        ${{number_format($course->price,2)}}
                                    @else 
                                        Credit
                                    @endif
                                </td>
                                <td>{{$course->purchase_date}}</td>
                               
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{$courses->links()}}
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


