@component('mail::message')
<p>Hi {{$data['old_first_name']}} {{$data['old_last_name']}},</p>
<p>Details has been updated by you, please check the updated details below.</p>
@component('mail::table')
<table>
    @if(isset($data['salutation']))
        <tr>
            <td>Salutation</td>
            <td>:</td>
            <td>{{$data['salutation']}}</td>
        </tr>
    @endif
    @if(isset($data['first_name']))
        <tr>
            <td>First Name</td>
            <td>:</td>
            <td>{{$data['first_name']}}</td>
        </tr>
    @endif
    @if(isset($data['last_name']))
        <tr>
            <td>Last Name</td>
            <td>:</td>
            <td>{{$data['last_name']}}</td>
        </tr>
    @endif
    @if(isset($data['email']))
        <tr>
            <td>Email</td>
            <td>:</td>
            <td>{{$data['email']}}</td>
        </tr>
    @endif
    @if(isset($data['password']))
        <tr>
            <td>Password</td>
            <td>:</td>
            <td>{{$data['password']}}</td>
        </tr>
    @endif
    @if(isset($data['country_code']))
        <tr>
            <td>Country Code</td>
            <td>:</td>
            <td>{{$data['country_code']}}</td>
        </tr>
    @endif
    @if(isset($data['tel_phone']))
        <tr>
            <td>Contact Number</td>
            <td>:</td>
            <td>{{$data['tel_phone']}}</td>
        </tr>
    @endif
    @if(isset($data['status']))
        <tr>
            <td>Status</td>
            <td>:</td>
            <td>@if($data['status'] == 0)Inactive @elseif($data['status'] == 1) Active @endif</td>
        </tr>
    @endif
    @if(isset($data['email_notification']))
        <tr>
            <td>Newsletter</td>
            <td>:</td>
            <td>@if($data['email_notification'] == 0)No @elseif($data['email_notification'] == 1) Yes @endif</td>
        </tr>
    @endif
    @if(isset($data['adviser']))
        <tr>
            <td>Consent to marketing information</td>
            <td>:</td>
            <td>@if($data['adviser'] == 0)No @elseif($data['adviser'] == 1) Yes @endif</td>
        </tr>
    @endif
    @if(isset($data['updated_at_admin']))
        <tr>
            <td>Update on</td>
            <td>:</td>
            <td>{{   date("Y-m-d h:i A", strtotime($data['updated_at_admin']))  }}</td>
        </tr>
    @endif
</table>
@endcomponent

@component('mail::button', ['url' => $data['profile_url'] ])
Check your profile
@endcomponent
{{ config('app.name') }}
@endcomponent
