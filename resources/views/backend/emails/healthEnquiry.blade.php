@component('mail::message')
# New Health insurance enquiry from Dollar Dollar.


@component('mail::table')
<table>
    @if($data['coverage'])
        <tr>
            <td>1. What level of coverage would you like?</td>
            <td>:</td>
            <td>{{$data['coverage']}}</td>
        </tr>
    @endif

    @if($data['level'])
        <tr>
            <td>2. What level of coverage would you like?</td>
            <td>:</td>
            <td>{{$data['level']}}</td>
        </tr>
    @endif
    @if(count($data['times']))
        <tr>
            <td>3. When is the best time to reach you?</td>
            <td>:</td>
            <td>{{implode(', ',$data['times']) }}</td>
        </tr>
    @endif
    @if($data['other_value'])
        <tr>
            <td>Other Value</td>
            <td>:</td>
            <td>{{$data['other_value']}}</td>
        </tr>
    @endif

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

</table>
@endcomponent

@component('mail::button', ['url' => env('APP_URL').'/admin'])
View Dashboard
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
