@component('mail::message')
# New Investment enquiry from Dollar Dollar.


@component('mail::table')
<table>
    @if(count($data['goals']))
        <tr>
            <td>1. What is current your financial goal?</td>
            <td>:</td>
            <td>{{implode(', ',$data['goals']) }}</td>
        </tr>
    @endif

    @if(isset($data['goal_other_value']))
        <tr>
            <td>1.1 Other</td>
            <td>:</td>
            <td>{{$data['goal_other_value']}}</td>
        </tr>
    @endif
    @if($data['experience'])
        <tr>
            <td>2. Do you have any investment experience before?</td>
            <td>:</td>
            <td>{{$data['experience']}}</td>
        </tr>
    @endif
    @if(isset($data['experience_detail']))
        <tr>
            <td>2.1 Experience detail</td>
            <td>:</td>
            <td>{{$data['experience_detail']}}</td>
        </tr>
    @endif

    @if($data['risks'])
        <tr>
            <td>3. Which Risk Profile do you fall into?</td>
            <td>:</td>
            <td>{{implode(', ',$data['risks']) }}</td>
        </tr>
    @endif
    @if(isset($data['age']))
        <tr>
            <td>4. What is your age?</td>
            <td>:</td>
            <td>{{$data['age']}}</td>
        </tr>
    @endif

    @if(count($data['times']))
        <tr>
            <td>5. One of representative from DollarDollar's partner will go through the different quotes from different
                insurers that is most suitable to your needs. I consent that this assigned representative can contact me
                via the various communication (Voice Call, SMS and Email)
            </td>
            <td>:</td>
            <td>{{implode(', ',$data['times']) }}</td>
        </tr>
    @endif
    @if($data['other_value'])
        <tr>
            <td>5.1 Other Value</td>
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
