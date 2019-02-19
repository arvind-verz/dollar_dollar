@component('mail::message')
<p>Hi {{$data['first_name']}} {{$data['last_name']}},</p>
<p>Welcome to DollarDollar and Thank you for creating an account with us! You can get the best deals from our website to maximize your potential interest earned.</p>
<p>You can learn how to set a reminder for each bank deposit/product you have <a href="{{url('deposit-reminder')}}">here</a>.</p>
<p>Have any questions? Feel free to drop us an <a href="{{url('contact')}}">email</a> and we’re always here to help!</p>
<p>Regards,<br/>{{ config('app.name') }}</p>
<p><a href="@if(isset($data['ad_link'])){{$data['ad_link']}}@endif"><img src="@if(isset($data['ad'])){{asset($data['ad'])}}@endif" alt=""></a></p>
@endcomponent
