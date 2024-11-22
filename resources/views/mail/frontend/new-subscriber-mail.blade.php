<x-mail::message>
# Hello!

Thank You For Subscribing.

<x-mail::button :url="route('frontend.index')">
Visit Our Website
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
