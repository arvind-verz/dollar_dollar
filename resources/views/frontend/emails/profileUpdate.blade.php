@component('mail::message')
<p>Hi {{$data['sender_name']}},</p>
<p>Profile has been updated.</p>
<p>Regards,<br/>{{ config('app.name') }}</p>
@endcomponent
