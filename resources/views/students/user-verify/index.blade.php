@extends('backend.layouts.app')
@section('content')
@if (Session::has('message'))
      <div class="alert alert-success text-center">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
          <p>{{ Session::get('message') }}</p>
      </div>
  @endif
   <div class="container">
        <div class="col-md-12">
            <div class="card invoice_card">
                <div class="card-header bg-primary"><h5 class="text-center ">VERIFY ACCOUNT</h5></div>
                <div class="card-body ">
                    {!! $page->content!!}
                    <hr>
                    <form method="post" action="{{route('students.account-verify.uploadImage')}}"  enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <input type="file" class="form-control" name="file" accept="image/*"  required>
                            </div>
                            <div class="cold-md-6">
                                <button class="btn btn-primary btn-block">Upload Image</button>
                            </div> 
                        </div>
                    </form>
                    @if(auth()->user()->verifyimage)
                    <img  src="{{asset('storage/files/verify-img/'.auth()->user()->verifyimage->file_name)}}"
                                 style="width:50px;height:auto;" alt="" > 
                                 @if(auth()->user()->verify_status == 0)
                                 <span class="text-warning"><strong>Image Pending Admin Approval</strong></span>
                                 @else
                                 <span class="text-success"><strong>Image ID Approved</strong></span>
                                 @endif
                    @endif
                    <hr>
                    <div class="row">
                        <div class="col-md-2"></div>
                        <div class="col-md-8">
                            <table class="table">
                                <thead>
                                    <tr>
                                         <th class="text-center">VERIFICATION</th>
                                         <th class="text-center">STATUS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                     <tr>
                                         <td><b>EMAIL CONFIRMED</b></td>
                                         <td class="text-center">
                                             @if(auth()->user()->confirmed == 0)
                                             <span class="badge badge-danger">NO</span>
                                             @else
                                             <span class="badge badge-success">YES</span>
                                             @endif
                                         </td>
                                     </tr>
                                     <tr>
                                         <td><b>IMAGE OF ID</b></td>
                                         <td class="text-center">
                                             @if(auth()->user()->verify_status == 0)
                                             <span class="badge badge-danger">NO</span>
                                             @else
                                             <span class="badge badge-success">YES</span>
                                             @endif
                                         </td>
                                     </tr>
                                     <tr>
                                         <td><b>FIRST PAYMENT COMPLETE</b></td>
                                         <td class="text-center">
                                             @if(auth()->user()->f_pay_status == 0)
                                             <span class="badge badge-danger">NO</span>
                                             @else
                                             <span class="badge badge-success">YES</span>
                                             @endif
                                         </td>
                                     </tr>
                                </tbody>
                            </table> 
                        </div>
                        <div class="col-md-2"></div>
                    </div>
                </div>
                
            </div>
             
        </div>
    </div>
@endsection


