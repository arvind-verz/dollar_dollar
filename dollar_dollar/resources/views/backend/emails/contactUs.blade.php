@component('mail::message')
# New enquiry from Speedo Marine (Pte) Ltd.


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
            <td>{{$data['telephone']}}</td>
        </tr>
    @endif
    @if($data['feedback'])
        <tr>
            <td>Feedback</td>
            <td>:</td>
            <td>{{$data['feedback']}}</td>
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
