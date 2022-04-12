<div class="table-responsive">
    <table class="table table-striped table-hover table-bordered">
         
        <tr>
            <th>@lang('labels.frontend.user.profile.name')</th>
            <td>{{ $user->first_name }} {{ $user->middle_name }} {{ $user->last_name }} {{ $user->name_suffix }}</td>
        </tr>
        <tr>
            <th>@lang('labels.frontend.user.profile.email')</th>
            <td>{{ $user->email }}</td>
        </tr>
        @if($logged_in_user->hasRole('teacher'))
            <tr>
                <th>@lang('labels.backend.access.users.tabs.content.overview.status')</th>
                <td>{!! $logged_in_user->status_label !!}</td>
            </tr>
            <tr>
                <th>@lang('labels.backend.general_settings.user_registration_settings.fields.gender')</th>
                <td>{!! $logged_in_user->gender !!}</td>
            </tr>
            @php
                $teacherProfile = $logged_in_user->teacherProfile?:'';
                $payment_details = $logged_in_user->teacherProfile?json_decode($logged_in_user->teacherProfile->payment_details):new stdClass();
            @endphp
            <tr>
                <th>@lang('labels.teacher.facebook_link')</th>
                <td>{!! $teacherProfile->facebook_link !!}</td>
            </tr>
            <tr>
                <th>@lang('labels.teacher.twitter_link')</th>
                <td>{!! $teacherProfile->twitter_link !!}</td>
            </tr>
            <tr>
                <th>@lang('labels.teacher.linkedin_link')</th>
                <td>{!! $teacherProfile->linkedin_link !!}</td>
            </tr>
            <tr>
                <th>@lang('labels.teacher.payment_details')</th>
                <td>{!! $teacherProfile->payment_method !!}</td>
            </tr>
            @if($payment_details)
                @if($teacherProfile->payment_method == 'bank')
                <tr>
                    <th>@lang('labels.teacher.bank_details.name')</th>
                    <td>{!! $payment_details->bank_name !!}</td>
                </tr>
                <tr>
                    <th>@lang('labels.teacher.bank_details.ifsc_code')</th>
                    <td>{!! $payment_details->ifsc_code !!}</td>
                </tr>
                <tr>
                    <th>@lang('labels.teacher.bank_details.account')</th>
                    <td>{!! $payment_details->account_number !!}</td>
                </tr>
                <tr>
                    <th>@lang('labels.teacher.bank_details.holder_name')</th>
                    <td>{!! $payment_details->account_name !!}</td>
                </tr>
                @else
                <tr>
                    <th>@lang('labels.teacher.paypal_email')</th>
                    <td>{!! $payment_details->paypal_email !!}</td>
                </tr>
                @endif
            @endif
        @endif

        <!--<tr>-->
        <!--    <th>@lang('labels.frontend.user.profile.created_at')</th>-->
        <!--    <td>{{ timezone()->convertToLocal($user->created_at) }} ({{ $user->created_at->diffForHumans() }})</td>-->
        <!--</tr>-->
        <!--<tr>-->
        <!--    <th>@lang('labels.frontend.user.profile.last_updated')</th>-->
        <!--    <td>{{ timezone()->convertToLocal($user->updated_at) }} ({{ $user->updated_at->diffForHumans() }})</td>-->
        <!--</tr>-->
         <tr>
            <th>Phone</th>
            <td>{{ $user->phone }}</td>
        </tr>
        <tr>
            <th>Date of Birth</th>
            <td>{{ \Carbon\Carbon::parse($user->dob)->format('M d, Y') }}</td>
        </tr>
         <tr>
            <th>SS#</th>
            <td>{{ $user->social_security_number }}</td>
        </tr>
        <tr>
            <th>Address</th>
            <td>{{ $user->address }}</td>
        </tr>
        <tr>
            <th>City</th>
            <td>{{ $user->city }}</td>
        </tr>
        <tr>
            <th>Zip code</th>
            <td>{{ $user->pincode }}</td>
        </tr>
        <tr>
            <th>State</th>
            <td>{{ $user->state }}</td>
        </tr>
        <tr>
            <th>Country</th>
            <td>{{ $user->country }}</td>
        </tr>
        
    </table>
</div>
