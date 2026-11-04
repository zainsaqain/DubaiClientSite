<x-mail::message>
@if ($forAdmin)
# New customer account

{{ $customer->first_name ?: $customer->name }} {{ $customer->last_name }} has created a customer account.

**Email:** {{ $customer->email }}

**Country:** {{ $customer->country_of_residence }}
@else
# Welcome, {{ $customer->first_name ?: $customer->name }}!

Your Waheed Murad Tourism account is ready. You can now save experiences and manage your bookings from My Account.

<x-mail::button :url="route('account.dashboard')">
Open My Account
</x-mail::button>
@endif

Thanks,<br>
Waheed Murad Tourism
</x-mail::message>
