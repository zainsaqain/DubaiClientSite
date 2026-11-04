<?php

namespace App\Http\Controllers;

use App\Models\BankTransferPayment;
use App\Models\BankTransferSetting;
use App\Models\Booking;
use App\Models\Tour;
use App\Models\TourPrice;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function create(Tour $tour): View
    {
        abort_unless($tour->isPublic(), 404);

        return view('checkout.create', [
            'tour' => $tour->load('prices'),
            'bankTransferEnabled' => BankTransferSetting::query()->where('is_enabled', true)->exists(),
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
            'payment_method' => ['required', 'in:direct_bank_transfer'],
        ]);

        if (! BankTransferSetting::query()->where('is_enabled', true)->exists()) {
            throw ValidationException::withMessages(['payment_method' => 'Direct bank transfer is not currently available.']);
        }

        $price = filled($data['tour_price_id'] ?? null)
            ? TourPrice::query()->where('tour_id', $tour->id)->where('is_active', true)->find($data['tour_price_id'])
            : null;

        if (filled($data['tour_price_id'] ?? null) && ! $price) {
            throw ValidationException::withMessages(['tour_price_id' => 'Please choose a valid tour option.']);
        }

        $adults = (int) $data['adults'];
        $children = (int) ($data['children'] ?? 0);
        $infants = (int) ($data['infants'] ?? 0);
        $amount = ($price?->adult_price ?? $tour->starting_price) * $adults
            + ($price?->child_price ?? 0) * $children;

        $booking = DB::transaction(function () use ($request, $tour, $price, $data, $adults, $children, $infants, $amount): Booking {
            $booking = Booking::query()->create([
                'user_id' => $request->user()->id,
                'tour_id' => $tour->id,
                'tour_price_id' => $price?->id,
                'order_number' => $this->orderNumber(),
                'travel_date' => $data['travel_date'],
                'adults' => $adults,
                'children' => $children,
                'infants' => $infants,
                'amount' => $amount,
                'currency' => $price?->currency ?? $tour->currency,
                'payment_method' => 'direct_bank_transfer',
                'payment_status' => 'pending_payment',
                'status' => 'pending_payment',
            ]);

            BankTransferPayment::query()->create(['booking_id' => $booking->id]);

            return $booking;
        });

        return redirect()->route('bank-transfer.show', $booking)->with('success', 'Your order has been created. Complete the transfer using the bank details below.');
    }

    private function orderNumber(): string
    {
        do {
            $orderNumber = 'WMT-'.now()->format('ymd').'-'.Str::upper(Str::random(6));
        } while (Booking::query()->where('order_number', $orderNumber)->exists());

        return $orderNumber;
    }
}
