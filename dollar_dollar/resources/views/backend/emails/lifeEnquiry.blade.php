@component('mail::message')
# New Life insurance enquiry from Dollar Dollar.


@component('mail::table')
<table>
    @if(count($data['components']))
        <tr>
            <td>1. What components of life insurance are you interested in?</td>
            <td>:</td>
            <td>{{implode(', ',$data['components']) }}</td>
        </tr>
    @endif

    @if($data['gender'])
        <tr>
            <td>2. What is your gender?</td>
            <td>:</td>
            <td>{{$data['gender']}}</td>
        </tr>
    @endif@if($data['dob'])
        <tr>
            <td>3. What is your date of birth?</td>
            <td>:</td>
            <td>{{$data['dob']}}</td>
        </tr>
    @endif
    @endif@if($data['smoke'])
        <tr>
            <td>4. Are you a smoker?</td>
            <td>:</td>
            <td>{{$data['smoke']}}</td>
        </tr>
    @endif
    @if(count($data['times']))
        <tr>
            <td>5. When is the best time to reach you?</td>
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
