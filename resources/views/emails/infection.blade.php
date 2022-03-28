@component('mail::message')
# Infection Notification

One of your team-mates has been infected

@component('mail::button', ['url' => url('/')])
Reserve vaccination
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
