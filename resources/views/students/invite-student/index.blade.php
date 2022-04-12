@extends('backend.layouts.app')
@section('content')
   @if(session()->has('success'))
        <div class="alert alert-dismissable alert-success fade show">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            {{session('success')}}
        </div>
    @endif
    
    
     @if(session()->has('error'))
        <div class="alert alert-dismissable alert-danger fade show">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            {{session('error')}}
        </div>
    @endif
    <div class="container">
        <div class="col-md-12">
            <div class="card invoice_card">
                <div class="card-header bg-primary"><h5 class="text-center ">EMAIL INVITE RULES</h5></div>
                <div class="card-body ">
                    {!! $page->content!!}
                </div>
            </div>
        </div>
    </div>
    
    <div class="container">
        <div class="col-md-12">
            <div class="card invoice_card">
                <div class="card-header bg-primary"><h5 class="text-center ">SEND EMAIL INVITE</h5></div>
                <div class="card-body ">
                    <form method="post" action="{{route('students.invite-student.invite_email')}}">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-md-4"><strong>PLACE THEIR FIRST NAME:</strong></div>
                            <div class="col-md-8">
                                <input type="text" class="form-control" placeholder="First Name" name="first_name" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4"><strong>PLACE THEIR EMAIL ADDRESS:</strong></div>
                            <div class="col-md-8">
                                <input type="email" class="form-control" placeholder="Email Address" name="email" required>
                            </div>
                        </div>
                        
                        @if($logged_in_user->verify_status == 1 && $logged_in_user->confirmed == 1 && $logged_in_user->payment == 1)
                         <div class="row mb-3">
                            <div class="col-md-2">
                                <button class="btn btn-primary btn-block form-control">INVITE</button>
                            </div> 
                        </div>
                       @else
                        <div class="row mb-3">
                            <div class="col-md-8">
                                <span class="title" style="color:#ff0000;font-weight: bold;">You must confirm your account before you can send email invites</span>
                                
                            </div> 
                        </div>
                       @endif
                       
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


