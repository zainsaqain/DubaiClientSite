@extends('layouts.site')

@section('title', 'Profile | Waheed Murad Tourism')

@section('content')
    <section class="customer-account-page">
        <div class="customer-account-container customer-account-form-container">
            <x-breadcrumb :items="[['label' => 'Home', 'url' => route('home')], ['label' => 'My Account', 'url' => route('account.dashboard')], ['label' => 'Profile']]" />
            <header class="customer-account-heading"><span>YOUR DETAILS</span><h1>Edit Profile</h1><p>Keep your details current for a smoother booking experience.</p></header>
            @include('customer.partials.navigation')
            @if (session('status') === 'profile-updated')<div class="customer-account-alert">Your profile details have been saved.</div>@endif

            <form method="POST" action="{{ route('account.profile.update') }}" class="customer-profile-form">
                @csrf
                @method('PATCH')
                <div class="customer-form-grid">
                    <label>First name<input name="first_name" value="{{ old('first_name', $user->first_name) }}" required autocomplete="given-name">@error('first_name')<small>{{ $message }}</small>@enderror</label>
                    <label>Last name<input name="last_name" value="{{ old('last_name', $user->last_name) }}" required autocomplete="family-name">@error('last_name')<small>{{ $message }}</small>@enderror</label>
                    <label>Date of birth<input type="date" name="date_of_birth" value="{{ old('date_of_birth', $user->date_of_birth?->format('Y-m-d')) }}" required autocomplete="bday">@error('date_of_birth')<small>{{ $message }}</small>@enderror</label>
                    <label>Country of residence<select name="country_of_residence" required><option value="">Select country</option>@foreach (config('countries.names') as $country)<option value="{{ $country }}" @selected(old('country_of_residence', $user->country_of_residence) === $country)>{{ $country }}</option>@endforeach</select>@error('country_of_residence')<small>{{ $message }}</small>@enderror</label>
                    <label>Country code<select name="phone_country_code" required>@foreach (config('countries.phone_codes') as $code => $country)<option value="{{ $code }}" @selected(old('phone_country_code', $user->phone_country_code ?: '+971') === $code)>{{ $code }} {{ $country }}</option>@endforeach</select>@error('phone_country_code')<small>{{ $message }}</small>@enderror</label>
                    <label>Phone number<input type="tel" name="phone_number" value="{{ old('phone_number', $user->phone_number) }}" required autocomplete="tel-national">@error('phone_number')<small>{{ $message }}</small>@enderror</label>
                    <label>Email address<input type="email" name="email" value="{{ old('email', $user->email) }}" required autocomplete="email">@error('email')<small>{{ $message }}</small>@enderror</label>
                    <label>Confirm email address<input type="email" name="email_confirmation" value="{{ old('email_confirmation', $user->email) }}" required autocomplete="email">@error('email_confirmation')<small>{{ $message }}</small>@enderror</label>
                </div>
                <button type="submit">Save profile <span>→</span></button>
            </form>
        </div>
    </section>
@endsection
