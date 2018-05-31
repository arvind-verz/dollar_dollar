@component('mail::message')
# Notification of New user register


@component('mail::table')
<table>
    <tr>
        <td>User Name</td>
        <td>:</td>
        <td>{{Auth::user()->first_name.' '.Auth::user()->first_name}}</td>
    </tr>
    <tr>
        <td>Email</td>
        <td>:</td>
        <td>{{Auth::user()->email}}</td>
    </tr>
    @if(Auth::user()->created_at)
        <tr>
            <td>Created on</td>
            <td>:</td>
            <td>{{   date("Y-m-d h:i A", strtotime(Auth::user()->created_at))  }}</td>
        </tr>
    @endif
</table>
@endcomponent

@component('mail::button', ['url' => env('APP_URL').'/admin'])
View Dashboard
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
