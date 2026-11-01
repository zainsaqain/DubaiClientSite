@extends('admin.layouts.app')

@section('title', 'My Profile')

@section('content')
    @php
        $initials = collect(explode(' ', $user->name))->filter()->map(fn ($part) => strtoupper(mb_substr($part, 0, 1)))->take(2)->implode('') ?: 'WM';
    @endphp

    <div class="wmt-admin-shell">
        @include('admin.partials.sidebar')

        <main class="wmt-admin-main wmt-admin-profile-page">
            <header class="wmt-admin-topbar">
                <div>
                    <p>ACCOUNT SETTINGS</p>
                    <h1>My profile</h1>
                </div>
                <div class="wmt-admin-actions">
                    <a class="wmt-admin-site-link" href="{{ route('admin.dashboard') }}">Back to dashboard <span>←</span></a>
                    <a class="wmt-admin-account" href="{{ route('profile.edit') }}" aria-current="page">
                        <b>{{ $initials }}</b>
                        <span><strong>{{ $user->name }}</strong><small>Administrator</small></span>
                    </a>
                </div>
            </header>

            <section class="wmt-profile-hero" aria-labelledby="profile-heading">
                <div class="wmt-profile-avatar">{{ $initials }}</div>
                <div>
                    <span>WAHEED MURAD TOURISM</span>
                    <h2 id="profile-heading">Your account, beautifully managed.</h2>
                    <p>Keep your contact details and account security up to date.</p>
                </div>
            </section>

            @if (session('status') === 'profile-updated')
                <div class="wmt-profile-alert" role="status">Your profile details have been saved.</div>
            @endif

            @if (session('status') === 'password-updated')
                <div class="wmt-profile-alert" role="status">Your password has been updated.</div>
            @endif

            <div class="wmt-profile-grid">
                <section class="wmt-admin-panel wmt-profile-card" aria-labelledby="profile-information-heading">
                    <div class="wmt-admin-panel-heading">
                        <div>
                            <span>PERSONAL DETAILS</span>
                            <h2 id="profile-information-heading">Profile information</h2>
                        </div>
                    </div>
                    <p class="wmt-profile-intro">Update the name and email address shown across your admin workspace.</p>

                    <form method="POST" action="{{ route('profile.update') }}" class="wmt-profile-form">
                        @csrf
                        @method('PATCH')

                        <label for="name">Full name
                            <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
                            @error('name') <small class="wmt-profile-error">{{ $message }}</small> @enderror
                        </label>

                        <label for="email">Email address
                            <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required autocomplete="username">
                            @error('email') <small class="wmt-profile-error">{{ $message }}</small> @enderror
                        </label>

                        <button type="submit" class="wmt-profile-submit">Save profile <span>→</span></button>
                    </form>
                </section>

                <section class="wmt-admin-panel wmt-profile-card" aria-labelledby="password-heading">
                    <div class="wmt-admin-panel-heading">
                        <div>
                            <span>ACCOUNT SECURITY</span>
                            <h2 id="password-heading">Change password</h2>
                        </div>
                    </div>
                    <p class="wmt-profile-intro">Use a long, unique password to keep your administration account secure.</p>

                    <form method="POST" action="{{ route('password.update') }}" class="wmt-profile-form">
                        @csrf
                        @method('PUT')

                        <label for="current_password">Current password
                            <input id="current_password" name="current_password" type="password" autocomplete="current-password">
                            @error('current_password', 'updatePassword') <small class="wmt-profile-error">{{ $message }}</small> @enderror
                        </label>

                        <label for="password">New password
                            <input id="password" name="password" type="password" autocomplete="new-password">
                            @error('password', 'updatePassword') <small class="wmt-profile-error">{{ $message }}</small> @enderror
                        </label>

                        <label for="password_confirmation">Confirm new password
                            <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password">
                        </label>

                        <button type="submit" class="wmt-profile-submit">Update password <span>→</span></button>
                    </form>
                </section>
            </div>

            <section class="wmt-admin-panel wmt-profile-danger" aria-labelledby="delete-account-heading">
                <div>
                    <span>ACCOUNT MANAGEMENT</span>
                    <h2 id="delete-account-heading">Delete account</h2>
                    <p>This permanently removes your account and its associated data. This action cannot be undone.</p>
                </div>
                <form method="POST" action="{{ route('profile.destroy') }}" onsubmit="return confirm('Delete your account permanently?');">
                    @csrf
                    @method('DELETE')
                    <label for="delete_password" class="sr-only">Current password</label>
                    <input id="delete_password" name="password" type="password" placeholder="Current password" autocomplete="current-password" required>
                    @error('password', 'userDeletion') <small class="wmt-profile-error">{{ $message }}</small> @enderror
                    <button type="submit">Delete account</button>
                </form>
            </section>
        </main>
    </div>
@endsection
