@component('mail::message')
<p>Hi {{$data['full_name']}},</p>
<p>Thank you for sending us your enquiry.</p>
<p>We will respond to you within two working days. Thank you for your patience.</p>
<p>Please <span style="font-weight: 700; text-decoration: underline">do not</span> reply to this email as this is an automated response. Any email sent to this account will not be received.</p>
<p>Have a great day ahead! </p>
<p>Regards,<br/>DollarDollar.sg</p>
<p><a href="@if(isset($data['ad_link'])){{$data['ad_link']}}@endif"><img src="@if(isset($data['ad'])){{asset($data['ad'])}}@endif" alt=""></a></p>
@endcomponent
