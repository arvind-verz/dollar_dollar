@component('mail::message')
# Welcome to Speedo Marine (Pte) Ltd

Thanks for signing up.**We really appreciate** it.Let us know if we can do more to please you!

@component('mail::button', ['url' =>  env('APP_URL').'/login'])
Log in to Speedo
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
