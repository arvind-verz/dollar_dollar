@component('mail::message')
<p>Hi Admin,</p>
@component('mail::table')
<table>
    <tr>
        <td>User Name</td>
        <td>:</td>
        <td>{{$data['first_name']}} {{$data['last_name']}}</td>
    </tr>
    <tr>
        <td>Email</td>
        <td>:</td>
        <td>{{$data['email']}}</td>
    </tr>
    @if($data['tel_phone'])
    <tr>
        <td>Telephone</td>
        <td>:</td>
        <td>{{$data['tel_phone']}}</td>
    </tr>
    @endif
    @if($data['created_at'])
        <tr>
            <td>Created on</td>
            <td>:</td>
            <td>{{   date("Y-m-d H:i", strtotime($data['created_at']))  }}</td>
        </tr>
    @endif
</table>
@endcomponent

@component('mail::button', ['url' => $data['admin_url'] ])
View Dashboard
@endcomponent
{{ config('app.name') }}
@endcomponent
