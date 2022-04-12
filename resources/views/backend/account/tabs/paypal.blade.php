 
      
<div class="row">
    <div class="col">
        <div class="form-group mb-0 clearfix">
             <form method="post" action="{{route('admin.profile.updatePayPal')}}">
                 @csrf
                 <input type="hidden" name="user_id" value="{{$logged_in_user->id}}">
                <div class="row">
                    <div class="col-md-12">
                        <label>PayPal:</label>
                        <input type="email" class="form-control" placeholder="PayPal" name="paypal" value="{{ $logged_in_user->paypal_address}}" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-group mb-0 clearfix">
                            <button class="btn btn-success pull-right" type="submit">Update PayPal</button>
                        </div><!--form-group-->
                    </div><!--col-->
                </div>
             </form>
        </div><!--form-group-->
    </div><!--col-->
</div><!--row-->
 