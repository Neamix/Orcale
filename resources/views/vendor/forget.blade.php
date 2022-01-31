@component('mail::message')
# Forget Password

Forgetting happens, here's the link to reset your password:

@component('mail::button', ['url' => url('reset/'.$forget['email'].'/'.$forget['token'])])
Reset Password
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
