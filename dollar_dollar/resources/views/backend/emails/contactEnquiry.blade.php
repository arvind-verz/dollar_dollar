@component('mail::message')
# New contact enquiry from Dollar Dollar.


@component('mail::table')
<table>
    @if($data['full_name'])
        <tr>
            <td>Name</td>
            <td>:</td>
            <td>{{$data['full_name']}}</td>
        </tr>
    @endif
    @if($data['email'])
        <tr>
            <td>Email</td>
            <td>:</td>
            <td>{{$data['email']}}</td>
        </tr>
    @endif
    @if($data['telephone'])
        <tr>
            <td>Contact Number</td>
            <td>:</td>
            <td>{{$data['country_code']}} &emsp;{{$data['telephone']}}</td>
        </tr>
    @endif
    @if($data['subject'])
        <tr>
            <td>Subject</td>
            <td>:</td>
            <td>{{$data['subject']}}</td>
        </tr>
    @endif

    @if($data['message'])
        <tr>
            <td>Message</td>
            <td>:</td>
            <td>{{$data['message']}}</td>
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
