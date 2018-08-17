@component('mail::message')
<p>Hi {{$data['first_name']}} {{$data['last_name']}},</p>
<p>Welcome to Dollar Dollar.</p>
<p>Thank you for entrusting us to help you grow your money easily. Get the best deals with us, as we show you how you
    can manage your wealth smarter.</p>
<p>Rest assured that all your personal information will not be shared with any third party vendors.</p>
<p>For more information, you may read some of our useful tips and tricks in our blog <a href="{{$data['blog_url']}}">here</a>.
</p>
<p>Have a good rest of your day!</p>
{{ config('app.name') }}
@endcomponent
