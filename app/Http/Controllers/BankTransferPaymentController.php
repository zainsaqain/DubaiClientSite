<?php

namespace App\Http\Controllers;

use App\Models\BankTransferSetting;
use App\Models\Booking;
use App\Models\User;
use App\Notifications\BankTransferPaymentUpdatedNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class BankTransferPaymentController extends Controller
{
    public function show(Request $request, Booking $booking): View
    {
        $this->authorizeBooking($request, $booking);
        $setting = BankTransferSetting::query()->firstOrFail();

        return view('payments.bank-transfer.show', [
            'booking' => $booking->load(['tour', 'bankTransferPayment']),
            'setting' => $setting,
        ]);
    }

    public function submit(Request $request, Booking $booking): RedirectResponse
    {
        $this->authorizeBooking($request, $booking);
        $payment = $booking->bankTransferPayment()->firstOrFail();

        if (! in_array($payment->status, ['pending_payment', 'rejected'], true)) {
            throw ValidationException::withMessages(['transaction_reference' => 'This payment cannot be submitted again at its current status.']);
        }

        $data = $request->validate([
            'transaction_reference' => ['required', 'string', 'max:120', 'regex:/^[A-Za-z0-9_\/-]+$/'],
            'payment_date' => ['nullable', 'date', 'before_or_equal:today'],
            'screenshot' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ]);

        if ($request->hasFile('screenshot')) {
            if ($payment->screenshot_path) {
                Storage::disk('local')->delete($payment->screenshot_path);
            }

            $data['screenshot_path'] = $request->file('screenshot')->store('bank-transfer-payments', 'local');
        }

        $payment->update([
            ...$data,
            'status' => 'pending_verification',
            'submitted_at' => now(),
            'rejection_reason' => null,
        ]);
        $booking->update(['payment_status' => 'pending_verification', 'status' => 'pending_verification']);
        $notification = new BankTransferPaymentUpdatedNotification($booking->fresh(), 'A customer submitted bank transfer payment information and it is ready for verification.');
        User::query()->where('is_admin', true)->get()->each(function (User $admin) use ($notification): void {
            try {
                $admin->notify($notification);
            } catch (\Throwable $exception) {
                report($exception);
            }
        });

        return redirect()->route('bank-transfer.show', $booking)->with('success', 'Your payment information has been submitted successfully. Your order will be processed after payment verification.');
    }

    public function screenshot(Request $request, Booking $booking): StreamedResponse
    {
        $this->authorizeBooking($request, $booking);
        $path = $booking->bankTransferPayment()->value('screenshot_path');
        abort_unless($path && Storage::disk('local')->exists($path), 404);

        return Storage::disk('local')->response($path);
    }

    private function authorizeBooking(Request $request, Booking $booking): void
    {
        abort_unless($request->user()->is_admin || $booking->user_id === $request->user()->id, 403);
    }
}
