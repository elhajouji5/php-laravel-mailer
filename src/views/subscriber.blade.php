@component('mail::message')
# Good day
Recipient message goes here ....

@component('mail::button', ['url' => ''])
Greeting
@endcomponent

@component('mail::panel')
Thanks,<br>
{{ config('app.name') }}
@endcomponent
