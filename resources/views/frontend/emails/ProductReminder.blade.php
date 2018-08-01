@component('mail::message')
# Reminder mail from Dollar Dollar.

@component('mail::table')
<table>
    @if($reminder->account_name)
        <tr>
            <td>Greetings {{$reminder->account_name}}</td>
        </tr>
    @endif

    @if($reminder->end_date)
        <tr>
            <td>
                <p>This serves as your friendly reminder that you have until {{date("Y-m-d", strtotime($reminder->end_date))}} before your purchased products expire.</p>
                <p>See product details attached.</p><br/><br/><br/>
                <p>Have a good day!</p>
            </td>
        </tr>
    @endif

</table>
@endcomponent

{{ config('app.name') }}
@endcomponent
