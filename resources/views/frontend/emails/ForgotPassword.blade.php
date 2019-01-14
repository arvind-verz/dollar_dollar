@component('mail::message')
<p>Greetings {{$data['first_name']}} {{$data['last_name']}},</p>
<p>You are reading this email because we have received a request from you to change your password.</p>
<p>To reset your password, you click the button below and follow the instructions stated there.</p>
@component('mail::button', ['url' => $data['url']])
Reset Password
@endcomponent
@component('mail::panel')
<p>We recommend that you keep your password confidential for extra security measures.</p>
<p>If you did not make such request, you can ignore this email. We assure you that your account is safe.</p>
@endcomponent
<p>For general enquiries or concerns, you may get in touch with us <a href="{{$data['contact_url']}}">here</a>.</p>
<p>Regards,<br/>DollarDollar.sg</p>
<p><a href="@if(isset($data['ad_link'])){{$data['ad_link']}}@endif"><img src="@if(isset($data['ad'])){{asset($data['ad'])}}@endif" alt=""></a></p>
@endcomponent
