@component('mail::message')
# New Newsletter Subscription

A new user has subscribed to the PhpForge newsletter.

**Subscriber Email:** {{ $email }}

@component('mail::button', ['url' => config('app.url')])
Visit Dashboard
@endcomponent

Best regards,<br>
{{ config('app.name') }} System
@endcomponent
