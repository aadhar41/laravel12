<x-mail::message>
# Welcome Aboard!

Hello {{ $user->name }},

Thank you for joining our application! We're excited to have you with us.

You can get started by exploring your dashboard:
<x-mail::button :url="url('/dashboard')">
Go to Dashboard
</x-mail::button>

If you have any questions, feel free to reply to this email.

Thanks,
{{ config('app.name') }} Team
</x-mail::message>
