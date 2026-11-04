<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\NewCustomerRegistered;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'date_of_birth' => ['required', 'date', 'before:today'],
            'country_of_residence' => ['required', 'string', 'max:100'],
            'phone_country_code' => ['required', 'string', 'max:8'],
            'phone_number' => ['required', 'string', 'max:32'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'email_confirmation' => ['required', 'same:email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => trim($request->string('first_name')->value().' '.$request->string('last_name')->value()),
            'first_name' => $request->string('first_name')->value(),
            'last_name' => $request->string('last_name')->value(),
            'date_of_birth' => $request->date('date_of_birth'),
            'country_of_residence' => $request->string('country_of_residence')->value(),
            'phone_country_code' => $request->string('phone_country_code')->value(),
            'phone_number' => $request->string('phone_number')->value(),
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Mail::to($user)->send(new NewCustomerRegistered($user));
        User::query()->where('is_admin', true)->each(function (User $admin) use ($user): void {
            Mail::to($admin)->send(new NewCustomerRegistered($user, true));
        });

        Auth::login($user);

        return redirect()->route('account.dashboard');
    }
}
