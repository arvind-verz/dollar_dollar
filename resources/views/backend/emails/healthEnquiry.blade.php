@component('mail::message')
# New Health insurance enquiry from Dollar Dollar.


@component('mail::table')
<table>
    <tr>
        <td>
            <table style="margin: 2px;">
                @if($data['full_name'])
                    <tr>
                        <td>Full Name</td>
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
                        <td>Mobile</td>
                        <td>:</td>
                        <td>{{$data['country_code']}} &emsp;{{$data['telephone']}}</td>
                    </tr>
                @endif

            </table>
        </td>
    </tr>
    @if($data['coverage'])
        <tr>
            <td>1. What type of coverage would you like?</td>
        </tr>
        <tr>
            <td>- {{$data['coverage']}}</td>
        </tr>
    @endif

    @if($data['level'])
        <tr>
            <td>2. Do you have any existing health condition?</td>
        </tr>
        <tr>
            <td>- {{$data['level']}}</td>
        </tr>
    @endif
    @if($data['health_condition'])
        <tr>
            <td>Please briefly state what health conditions you have</td>
        </tr>
        <tr>
            <td>- {{$data['health_condition']}}</td>
        </tr>
    @endif
    @if(count($data['time']))
        <tr>
            <td>3. One of representative from DollarDollar's partner will go through the different quotes from different
                insurers that is most suitable to your needs. I consent that this assigned representative can contact me
                via the various communication (Voice Call, SMS and Email)
            </td>
        </tr>
        <tr>
            <td>- {{implode(', ',$data['time']) }}</td>
        </tr>
    @endif
    @if($data['other_value'])
        <tr>
            <td>3.1. Other Value</td>
        </tr>
        <tr>
            <td>
               - {{$data['other_value']}}
            </td>
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
