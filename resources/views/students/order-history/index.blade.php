@extends('backend.layouts.app')
@section('content')
   <div class="container">
        <div class="col-md-12">
            <div class="card" style="overflow:scroll;min-width:300px;">
                <div class="card-header bg-primary"><h5 class="text-center ">My Order History</h5></div>
                <div class="card-body ">
                    <table class="table">
                        <thead>
                            <tr>
                                 <th>Order Type</th>
                                 <th>Price</th>
                                 <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                            <tr>
                                <td>
                                    @if($order->transaction_type == 'Course Purchase') {{$order->course_name}}
                                    @else {{$order->transaction_type}}
                                    @endif
                                </td>
                                <td>
                                    @if($order->card_status == 1)
                                        ${{number_format($order->amount,2)}}
                                    @else 
                                        Credit
                                    @endif
                                </td>
                                <td>{{$order->date}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{$orders->links()}}
                </div>
            </div>
        </div>
    </div>
@endsection


