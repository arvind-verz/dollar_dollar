@component('mail::message')
# Reminder mail from Dollar Dollar.

Dear {{$reminder->account_name}},

@component('mail::table')
<table>
    @if($reminder->account_name)
        <tr>
            <td>Account Name</td>
            <td>:</td>
            <td>{{$reminder->account_name}}</td>
        </tr>
    @endif
    @if($reminder->amount)
        <tr>
            <td>Amount</td>
            <td>:</td>
            <td>{{$reminder->amount}}</td>
        </tr>
    @endif
    @if($reminder->tenure)
        <tr>
            <td>Tenure</td>
            <td>:</td>
            <td>{{$reminder->tenure}}</td>
        </tr>
    @endif
    @if($reminder->start_date)
        <tr>
            <td>Start Date</td>
            <td>:</td>
            <td>{{date("Y-m-d", strtotime($reminder->start_date))}}</td>
        </tr>
    @endif

    @if($reminder->end_date)
        <tr>
            <td>End Date</td>
            <td>:</td>
            <td>{{date("Y-m-d", strtotime($reminder->end_date))}}</td>
        </tr>
    @endif
        @if($reminder->interest_earned)
            <tr>
                <td>Interest Earned</td>
                <td>:</td>
                <td>{{$reminder->interest_earned}}</td>
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
