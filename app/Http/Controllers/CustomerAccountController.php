<?php

namespace App\Http\Controllers;

use App\Models\Tour;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CustomerAccountController extends Controller
{
    public function dashboard(Request $request): View
    {
        return view('customer.dashboard', ['user' => $this->customer($request)]);
    }

    public function profile(Request $request): View
    {
        return view('customer.profile', ['user' => $this->customer($request)]);
    }

    public function updateProfile(Request $request): RedirectResponse
    {
        $user = $this->customer($request);
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'date_of_birth' => ['required', 'date', 'before:today'],
            'country_of_residence' => ['required', 'string', 'max:100'],
            'phone_country_code' => ['required', 'string', 'max:8'],
            'phone_number' => ['required', 'string', 'max:32'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
            'email_confirmation' => ['required', 'same:email'],
        ]);

        $user->fill([
            ...$validated,
            'name' => trim($validated['first_name'].' '.$validated['last_name']),
        ]);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('account.profile')->with('status', 'profile-updated');
    }

    public function orders(Request $request): View
    {
        return view('customer.orders', ['user' => $this->customer($request)]);
    }

    public function wishlist(Request $request): View
    {
        $user = $this->customer($request);
        $wishlists = $user->wishlists()
            ->with(['tour.category', 'tour.subcategory', 'tour.images', 'tour.prices'])
            ->latest()
            ->get();

        return view('customer.wishlist', compact('user', 'wishlists'));
    }

    public function storeWishlist(Request $request, Tour $tour): RedirectResponse
    {
        $user = $this->customer($request);

        abort_unless($tour->isPublic(), 404);

        $user->wishlists()->firstOrCreate(['tour_id' => $tour->id]);

        return back()->with('wishlist-status', 'Experience added to your wishlist.');
    }

    public function destroyWishlist(Request $request, Tour $tour): RedirectResponse
    {
        $user = $this->customer($request);

        $user->wishlists()->where('tour_id', $tour->id)->delete();

        return back()->with('wishlist-status', 'Experience removed from your wishlist.');
    }

    private function customer(Request $request): User
    {
        $user = $request->user();

        abort_unless($user instanceof User && ! $user->is_admin, 403);

        return $user;
    }
}
