<div class="col">
    <div class="table-responsive">
        <table class="table table-hover">
            <!--<tr>-->
            <!--    <th>@lang('labels.backend.access.users.tabs.content.overview.avatar')</th>-->
            <!--    <td><img src="{{ $user->picture }}" class="user-profile-image" /></td>-->
            <!--</tr>-->

            <tr>
                <th>@lang('labels.backend.access.users.tabs.content.overview.name')</th>
                <td>{{ $user->first_name }} {{ $user->middle_name }} {{ $user->last_name }} {{ $user->name_suffix }}</td>
            </tr>

            <tr>
                <th>@lang('labels.backend.access.users.tabs.content.overview.email')</th>
                <td>{{ $user->email }}</td>
            </tr>
            
            <tr>
                <th>BirthDay</th>
                <td>{{ \Carbon\Carbon::parse($user->dob)->format('M d, Y') }}</td>
            </tr>
            
            <tr>
                <th>Address</th>
                <td> {{ $user->address }}, {{ $user->city }}, {{ $user->state }}, {{ $user->pincode }}</td>
            </tr>
            <tr>
                <th>Phone</th>
                <td>{{$user->phone }}</td>
            </tr>
            <tr>
                <th>SSN</th>
                <td>{{$user->social_security_number }}</td>
            </tr>

            <tr>
                <th>@lang('labels.backend.access.users.tabs.content.overview.status')</th>
                <td>{!! $user->status_label !!}</td>
            </tr>

            <tr>
                <th>@lang('labels.backend.access.users.tabs.content.overview.confirmed')</th>
                <td>{!! $user->confirmed_label !!}</td>
            </tr>
            <tr>
                <th>Image Verify</th>
                <td> 
                    {!! $user->verify_label !!}<span style="margin-left:20%;"></span>
                    <a href="{{route('admin.auth.user.verify',$user)}}" data-toggle="tooltip" data-placement="top" title="Approve" name="verify_item">
                        <span class="badge badge-success" style="cursor:pointer">Approve</span>
                    </a> | 
                    
                    <a href="{{route('admin.auth.user.unverify',$user)}}" data-toggle="tooltip" data-placement="top" title="Deny" name="verify_item">
                        <span class="badge badge-danger" style="cursor:pointer">Deny</span>
                    </a>
                </td>
            </tr>
            
            <tr>
                <th>Fist Payment Verify</th>
                <td> 
                    {!! $user->payment_verify_label !!}<span style="margin-left:20%;"></span>
                    <a href="{{route('admin.auth.user.pay_verify',$user)}}" data-toggle="tooltip" data-placement="top" title="Approve" name="verify_item">
                        <span class="badge badge-success" style="cursor:pointer">Approve</span>
                    </a> | 
                    
                    <a href="{{route('admin.auth.user.unpay_verify',$user)}}" data-toggle="tooltip" data-placement="top" title="Deny" name="verify_item">
                        <span class="badge badge-danger" style="cursor:pointer">Deny</span>
                    </a>
                </td>
            </tr>

            <!--<tr>-->
            <!--    <th>@lang('labels.backend.access.users.tabs.content.overview.timezone')</th>-->
            <!--    <td>{{ $user->timezone }}</td>-->
            <!--</tr>-->

            <tr>
                <th>@lang('labels.backend.access.users.tabs.content.overview.last_login_at')</th>
                <td>
                    @if($user->last_login_at)
                        {{ timezone()->convertToLocal($user->last_login_at) }}
                    @else
                        N/A
                    @endif
                </td>
            </tr>

            <tr>
                <th>@lang('labels.backend.access.users.tabs.content.overview.last_login_ip')</th>
                <td>{{ $user->last_login_ip ?? 'N/A' }}</td>
            </tr>
            
            @if($user->verifyimage)
            <tr>
                <th>Verify</th>
                <td>
                    <img  src="{{asset('storage/files/verify-img/'.$user->verifyimage->file_name)}}"
                         style="width:500px;height:400px;"    alt=""  class="user-profile-image" >
                </td>
            </tr>
            @endif
             
           

        </table>
    </div>
</div><!--table-responsive-->
