@component('mail::message')
# Welcome to PhpForge Newsletter!

Thank you for subscribing to our newsletter. You'll be among the first to receive:
- Latest updates and features
- PHP development tips and tricks
- Exclusive content and tutorials
- Special offers and announcements

Stay tuned for our next update!

Best regards,<br>
The {{ config('app.name') }} Team

@component('mail::button', ['url' => config('app.url')])
Visit PhpForge
@endcomponent

@endcomponent
