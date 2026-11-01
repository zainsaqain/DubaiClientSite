<x-guest-layout>
    <div class="wmt-auth-heading">
        <p>WELCOME BACK</p>
        <h1>Sign in to your<br><em>admin workspace.</em></h1>
        <span>Manage your Dubai tourism experiences with ease.</span>
    </div>

    <x-auth-session-status class="wmt-auth-status" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="wmt-auth-form">
        @csrf

        <div class="wmt-auth-field">
            <label for="email">Email address</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="you@company.com">
            @error('email')<p class="wmt-auth-error">{{ $message }}</p>@enderror
        </div>

        <div class="wmt-auth-field">
            <label for="password">Password</label>
            <input id="password" type="password" name="password" required autocomplete="current-password" placeholder="Enter your password">
            @error('password')<p class="wmt-auth-error">{{ $message }}</p>@enderror
        </div>

        <div class="wmt-auth-options">
            <label for="remember_me"><input id="remember_me" type="checkbox" name="remember"><span>Remember me</span></label>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}">Forgot password?</a>
            @endif
        </div>

        <button type="submit" class="wmt-auth-submit">Sign in to dashboard <span>→</span></button>

        @if (Route::has('register'))
            <p class="wmt-auth-switch">New to Waheed Murad Tourism? <a href="{{ route('register') }}">Create an account</a></p>
        @endif
    </form>
</x-guest-layout>
