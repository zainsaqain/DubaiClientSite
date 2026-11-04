<x-guest-layout>
    <div class="wmt-auth-heading">
        <p>CREATE ACCOUNT</p>
        <h1>Your Dubai<br><em>journey starts here.</em></h1>
        <span>Create an account to save experiences and manage your bookings.</span>
    </div>

    <form method="POST" action="{{ route('register') }}" class="wmt-auth-form">
        @csrf

        <div class="wmt-auth-split">
            <div class="wmt-auth-field"><label for="first_name">First name</label><input id="first_name" type="text" name="first_name" value="{{ old('first_name') }}" required autofocus autocomplete="given-name"><x-input-error :messages="$errors->get('first_name')" /></div>
            <div class="wmt-auth-field"><label for="last_name">Last name</label><input id="last_name" type="text" name="last_name" value="{{ old('last_name') }}" required autocomplete="family-name"><x-input-error :messages="$errors->get('last_name')" /></div>
        </div>

        <div class="wmt-auth-field"><label for="date_of_birth">Date of birth</label><input id="date_of_birth" type="date" name="date_of_birth" value="{{ old('date_of_birth') }}" required autocomplete="bday"><x-input-error :messages="$errors->get('date_of_birth')" /></div>
        <div class="wmt-auth-field"><label for="country_of_residence">Country of residence</label><select id="country_of_residence" name="country_of_residence" required autocomplete="country-name"><option value="">Select country</option>@foreach (config('countries.names') as $country)<option value="{{ $country }}" @selected(old('country_of_residence') === $country)>{{ $country }}</option>@endforeach</select><x-input-error :messages="$errors->get('country_of_residence')" /></div>
        <div class="wmt-auth-field"><label for="phone_number">Phone number</label><div class="wmt-auth-phone"><select id="phone_country_code" name="phone_country_code" required aria-label="Phone country code">@foreach (config('countries.phone_codes') as $code => $country)<option value="{{ $code }}" @selected(old('phone_country_code', '+971') === $code)>{{ $code }} {{ $country }}</option>@endforeach</select><input id="phone_number" type="tel" name="phone_number" value="{{ old('phone_number') }}" required autocomplete="tel-national" placeholder="Phone number"></div><x-input-error :messages="$errors->get('phone_country_code')" /><x-input-error :messages="$errors->get('phone_number')" /></div>

        <div class="wmt-auth-field">
            <label for="email">Email address</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="you@company.com">
            @error('email')<p class="wmt-auth-error">{{ $message }}</p>@enderror
        </div>

        <div class="wmt-auth-field">
            <label for="email_confirmation">Confirm email address</label>
            <input id="email_confirmation" type="email" name="email_confirmation" value="{{ old('email_confirmation') }}" required autocomplete="email" placeholder="Re-enter your email">
            <x-input-error :messages="$errors->get('email_confirmation')" />
        </div>

        <div class="wmt-auth-field">
            <label for="password">Password</label>
            <input id="password" type="password" name="password" required autocomplete="new-password" placeholder="Create a password">
            @error('password')<p class="wmt-auth-error">{{ $message }}</p>@enderror
        </div>

        <div class="wmt-auth-field">
            <label for="password_confirmation">Confirm password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm your password">
            @error('password_confirmation')<p class="wmt-auth-error">{{ $message }}</p>@enderror
        </div>

        <button type="submit" class="wmt-auth-submit">Create account <span>→</span></button>
        <p class="wmt-auth-switch">Already registered? <a href="{{ route('login') }}">Sign in instead</a></p>
    </form>
</x-guest-layout>
