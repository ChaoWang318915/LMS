@extends('backend.layouts.app')
@section('content')
   <div class="container">
        <div class="col-md-12">
            <div class="card invoice_card">
                <div class="card-header bg-primary"><h5 class="text-center ">HOW TO</h5></div>
                <div class="card-body ">
                     {!! $page->content!!}
                </div>
            </div>
        </div>
    </div>
@endsection


