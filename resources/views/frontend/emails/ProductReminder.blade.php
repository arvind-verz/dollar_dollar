@component('mail::message')
# Reminder mail from Dollar Dollar.

Dear {{$data['account_name']}},

@component('mail::table')
<table>
    @if($data['account_name'])
        <tr>
            <td>Account Name</td>
            <td>:</td>
            <td>{{$data['account_name']}}</td>
        </tr>
    @endif
    @if($data['amount'])
        <tr>
            <td>Amount</td>
            <td>:</td>
            <td>{{$data['amount']}}</td>
        </tr>
    @endif
    @if($data['tenure'])
        <tr>
            <td>Tenure</td>
            <td>:</td>
            <td>{{$data['tenure']}}</td>
        </tr>
    @endif
    @if($data['start_date'])
        <tr>
            <td>Start Date</td>
            <td>:</td>
            <td>{{date("Y-m-d", strtotime($data['start_date']))}}</td>
        </tr>
    @endif

    @if($data['end_date'])
        <tr>
            <td>End Date</td>
            <td>:</td>
            <td>{{date("Y-m-d", strtotime($data['end_date']))}}</td>
        </tr>
    @endif
    @if($data['interest_earned'])
        <tr>
            <td>Interest Earned</td>
            <td>:</td>
            <td>{{$data['interest_earned']}}</td>
        </tr>
    @endif

</table>
@endcomponent

@component('mail::button', ['url' => env('APP_URL').'/login'])
View Account
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
