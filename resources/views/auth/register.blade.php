<x-guest-layout>
    <div class="wmt-auth-heading">
        <p>CREATE ACCOUNT</p>
        <h1>Start your<br><em>admin journey.</em></h1>
        <span>Create your account to manage Waheed Murad Tourism.</span>
    </div>

    <form method="POST" action="{{ route('register') }}" class="wmt-auth-form">
        @csrf

        <div class="wmt-auth-field">
            <label for="name">Full name</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="Your full name">
            @error('name')<p class="wmt-auth-error">{{ $message }}</p>@enderror
        </div>

        <div class="wmt-auth-field">
            <label for="email">Email address</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="you@company.com">
            @error('email')<p class="wmt-auth-error">{{ $message }}</p>@enderror
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
