@component('mail::message')
# New Investment enquiry from Dollar Dollar.


@component('mail::table')
<table>
    @if(count($data['components']))
        <tr>
            <td>1. What type of life insurance are you looking for?</td>
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
    @endif

    @if($data['dob'])
        <tr>
            <td>3. What is your date of birth?</td>
            <td>:</td>
            <td>{{$data['dob']}}</td>
        </tr>
    @endif

    @if($data['smoke'])
        <tr>
            <td>4. Are you a smoker?</td>
            <td>:</td>
            <td>{{$data['smoke']}}</td>
        </tr>
    @endif
    
    @if(count($data['time']))
        <tr>
            <td>5. One of representative from DollarDollar's partner will go through the different quotes from different insurers that is most suitable to your needs. I consent that this assigned representative can contact me via the various communication (Voice Call, SMS and Email)</td>
            <td>:</td>
            <td>{{implode(', ',$data['time']) }}</td>
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
            <td>Fullname</td>
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
