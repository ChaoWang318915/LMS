@extends('backend.layouts.app')
@section('content')
   <div class="container">
        <div class="col-md-12">
            <div class="card" style="overflow:scroll;min-width:300px;">
                <div class="card-header bg-primary"><h5 class="text-center ">My Payment History</h5></div>
                <div class="card-body ">
                    <table class="table">
                        <thead>
                            <tr>
                                 <th>Payment Reference #</th>
                                 <th>Amount Paid</th>
                                 <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($payments as $payment)
                            <tr>
                                <td>{{$payment->reference}}</td>
                                <td>${{number_format($payment->amount,2)}}</td>
                                <td>{{$payment->payment_date}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{$payments->links()}}
                </div>
            </div>
        </div>
    </div>
@endsection


