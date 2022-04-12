@extends('backend.layouts.app')
@section('content')
   <div class="container">
        <div class="col-md-12">
            <div class="card invoice_card"  style="overflow:scroll;min-width:300px;">
                <div class="card-header bg-primary"><h5 class="text-center "> 1 Tier Commissions</h5></div>
                <div class="card-body ">
                    <table class="table">
                        <thead>
                            <tr>
                                 <th>Rewards Type</th>
                                 <th>Commission</th>
                                 <th>Status</th>
                                 <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rewards as $reward)
                            <tr>
                                <td>
                                    @if($reward->transaction_type == 'Course Purchase') {{$reward->course_name}}
                                    @else {{$reward->transaction_type}}
                                    @endif
                                </td>
                                <td>${{number_format($reward->commission,2)}}</td>
                                <td>
                                    @if($reward->status == 1)
                                    <span class="badge badge-danger">Waiting</span>
                                    @else
                                    <span class="badge badge-success">Paid</span>
                                    @endif
                                </td>
                                <td>{{$reward->date}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{$rewards->links()}}
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="col-md-12">
            <div class="card invoice_card"  style="overflow:scroll;min-width:300px;">
                <div class="card-header bg-primary"><h5 class="text-center "> 2 Tier Commissions</h5></div>
                <div class="card-body ">
                    <table class="table">
                        <thead>
                            <tr>
                                 <th>Rewards Type</th>
                                 <th>Commission</th>
                                 <th>Status</th>
                                 <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rewards_2 as $reward)
                            <tr>
                                <td>
                                    @if($reward->transaction_type == 'Course Purchase') {{$reward->course_name}}
                                    @else {{$reward->transaction_type}}
                                    @endif
                                </td>
                                <td>${{number_format($reward->commission,2)}}</td>
                                <td>
                                    @if($reward->status == 1)
                                    <span class="badge badge-danger">Waiting</span>
                                    @else
                                    <span class="badge badge-success">Paid</span>
                                    @endif
                                </td>
                                <td>{{$reward->date}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{$rewards_2->links()}}
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="col-md-12">
            <div class="card invoice_card">
                <div class="card-header bg-primary"><h5 class="text-center ">Reward Program</h5></div>
                <div class="card-body ">
                     {!! $page->content!!}
                </div>
            </div>
        </div>
    </div>
@endsection


