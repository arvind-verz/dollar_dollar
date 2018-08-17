@component('mail::message')
<p>Hi {{$data['first_name']}} {{$data['last_name']}},</p>
<p>Details update by admin please check your detail below. </p>
@component('mail::table')
<table>
    <tr>
        <td>Salutation</td>
        <td>:</td>
        <td>{{$data['salutation']}}</td>
    </tr>
    <tr>
        <td>First Name</td>
        <td>:</td>
        <td>{{$data['first_name']}}</td>
    </tr>
    <tr>
        <td>Last Name</td>
        <td>:</td>
        <td>={{$data['last_name']}}</td>
    </tr>
    <tr>
        <td>Email</td>
        <td>:</td>
        <td>{{$data['email']}}</td>
    </tr>
    @if($data['tel_phone'])
        <tr>
            <td>Contact Number</td>
            <td>:</td>
            <td>{{$data['tel_phone']}}</td>
        </tr>
    @endif
    @if($data['updated_at_admin'])
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
