<?php

namespace App\Http\Controllers;

use App\Models\Tour;
use App\Models\TourPrice;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class CartController extends Controller
{
    public function index(Request $request): View
    {
        $cart = collect($request->session()->get('cart', []));
        $tours = Tour::query()
            ->whereIn('id', $cart->pluck('tour_id')->filter())
            ->with(['category', 'subcategory'])
            ->get()
            ->keyBy('id');

        $items = $cart
            ->map(function (array $item, string $lineId) use ($tours): array {
                return [...$item, 'line_id' => $lineId, 'tour' => $tours->get($item['tour_id'])];
            })
            ->filter(fn (array $item): bool => $item['tour'] instanceof Tour)
            ->values();

        return view('cart.index', [
            'items' => $items,
            'cartTotals' => $items
                ->groupBy(fn (array $item): string => $item['currency'])
                ->map(fn ($items): float => (float) $items->sum('amount')),
        ]);
    }

    public function store(Request $request, Tour $tour): RedirectResponse
    {
        abort_unless($tour->isPublic(), 404);

        $data = $request->validate([
            'tour_price_id' => ['nullable', 'integer'],
            'travel_date' => ['required', 'date', 'after_or_equal:today'],
            'adults' => ['required', 'integer', 'min:1', 'max:50'],
            'children' => ['nullable', 'integer', 'min:0', 'max:50'],
            'infants' => ['nullable', 'integer', 'min:0', 'max:50'],
        ]);

        $price = filled($data['tour_price_id'] ?? null)
            ? $tour->prices()->where('is_active', true)->find($data['tour_price_id'])
            : null;

        if (filled($data['tour_price_id'] ?? null) && ! $price instanceof TourPrice) {
            throw ValidationException::withMessages(['tour_price_id' => 'Please choose a valid tour option.']);
        }

        $adults = (int) $data['adults'];
        $children = (int) ($data['children'] ?? 0);
        $infants = (int) ($data['infants'] ?? 0);
        $amount = (($price?->adult_price ?? $tour->starting_price) * $adults)
            + (($price?->child_price ?? 0) * $children)
            + (($price?->infant_price ?? 0) * $infants);
        $cart = $request->session()->get('cart', []);

        $cart[(string) Str::uuid()] = [
            'tour_id' => $tour->id,
            'tour_price_id' => $price?->id,
            'travel_date' => $data['travel_date'],
            'adults' => $adults,
            'children' => $children,
            'infants' => $infants,
            'amount' => $amount,
            'currency' => $price?->currency ?? $tour->currency,
        ];

        $request->session()->put('cart', $cart);

        return redirect()->route('cart.index')->with('cart-status', $tour->name.' has been added to your cart.');
    }

    public function destroy(Request $request, string $lineId): RedirectResponse
    {
        $cart = $request->session()->get('cart', []);

        unset($cart[$lineId]);

        $request->session()->put('cart', $cart);

        return back()->with('cart-status', 'Item removed from your cart.');
    }
}
