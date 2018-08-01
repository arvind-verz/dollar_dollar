@component('mail::message')
# Notification of New user register


@component('mail::table')
<table>
    <tr>
        <td>Hi, {{Auth::user()->first_name.' '.Auth::user()->first_name}}</td>
    </tr>
    <tr>
        <td>
            <p>Welcome to Dollar Dollar.</p>
            <p>Thank you for entrusting us to help you grow your money easily. Get the best deals with us, as we show you how you can manage your wealth smarter.</p>
            <p>Rest assured that all your personal information will not be shared with any third party vendors.</p>
            <p>For more information, you may read some of our useful tips and tricks in our blog here. [Link blog]</p>
            Have a good rest of your day!
        </td>
    </tr>
</table>
@endcomponent

{{ config('app.name') }}
@endcomponent
