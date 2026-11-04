<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BankTransferPayment;
use App\Notifications\BankTransferPaymentUpdatedNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class BankTransferPaymentController extends Controller
{
    public function index(Request $request): View
    {
        $payments = BankTransferPayment::query()
            ->with(['booking.user', 'booking.tour'])
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->string('status')->toString()))
            ->latest('submitted_at')
            ->paginate(20)
            ->withQueryString();

        return view('admin.bank-transfer.payments.index', compact('payments'));
    }

    public function show(BankTransferPayment $payment): View
    {
        return view('admin.bank-transfer.payments.show', ['payment' => $payment->load(['booking.user', 'booking.tour', 'verifier'])]);
    }

    public function approve(Request $request, BankTransferPayment $payment): RedirectResponse
    {
        $request->validate(['funds_received' => ['accepted']]);

        DB::transaction(function () use ($payment, $request): void {
            $payment = BankTransferPayment::query()->lockForUpdate()->findOrFail($payment->id);
            if ($payment->status === 'paid') {
                return;
            }
            if ($payment->status !== 'pending_verification') {
                throw ValidationException::withMessages(['funds_received' => 'Only submitted payments can be approved.']);
            }

            $payment->update([
                'status' => 'paid',
                'verified_at' => now(),
                'verified_by' => $request->user()->id,
                'rejection_reason' => null,
            ]);
            $payment->booking()->lockForUpdate()->firstOrFail()->update(['payment_status' => 'paid', 'status' => 'confirmed']);
            $this->audit($payment->id, $request->user()->id, 'approved', 'Admin confirmed funds were received.');
        });
        $this->notifyCustomer($payment->fresh(), 'Your bank transfer has been verified. Your booking is confirmed.');

        return back()->with('success', 'Payment approved and order marked as paid.');
    }

    public function reject(Request $request, BankTransferPayment $payment): RedirectResponse
    {
        $data = $request->validate(['rejection_reason' => ['required', 'string', 'max:2000']]);

        DB::transaction(function () use ($payment, $request, $data): void {
            $payment = BankTransferPayment::query()->lockForUpdate()->findOrFail($payment->id);
            if ($payment->status === 'paid') {
                throw ValidationException::withMessages(['rejection_reason' => 'A paid payment cannot be rejected.']);
            }

            $payment->update(['status' => 'rejected', 'rejection_reason' => $data['rejection_reason'], 'verified_at' => now(), 'verified_by' => $request->user()->id]);
            $payment->booking()->lockForUpdate()->firstOrFail()->update(['payment_status' => 'rejected', 'status' => 'pending_payment']);
            $this->audit($payment->id, $request->user()->id, 'rejected', $data['rejection_reason']);
        });
        $this->notifyCustomer($payment->fresh(), 'Your bank transfer payment needs correction. Please review the note and resubmit your payment information.');

        return back()->with('success', 'Payment rejected. The customer can submit corrected information.');
    }

    public function requestInformation(Request $request, BankTransferPayment $payment): RedirectResponse
    {
        $data = $request->validate(['admin_note' => ['required', 'string', 'max:2000']]);

        if ($payment->status === 'paid') {
            throw ValidationException::withMessages(['admin_note' => 'Additional information cannot be requested for a paid payment.']);
        }

        $payment->update(['status' => 'rejected', 'admin_note' => $data['admin_note'], 'rejection_reason' => $data['admin_note']]);
        $payment->booking()->update(['payment_status' => 'rejected', 'status' => 'pending_payment']);
        $this->audit($payment->id, $request->user()->id, 'information_requested', $data['admin_note']);
        $this->notifyCustomer($payment->fresh(), 'Additional information is required for your bank transfer payment. Please review the note and resubmit.');

        return back()->with('success', 'The customer can now submit corrected payment information.');
    }

    private function audit(int $paymentId, int $userId, string $action, ?string $note = null): void
    {
        DB::table('bank_transfer_payment_audits')->insert([
            'bank_transfer_payment_id' => $paymentId,
            'user_id' => $userId,
            'action' => $action,
            'note' => $note,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    private function notifyCustomer(BankTransferPayment $payment, string $message): void
    {
        try {
            $payment->loadMissing('booking.user');
            $payment->booking->user->notify(new BankTransferPaymentUpdatedNotification($payment->booking, $message));
        } catch (\Throwable $exception) {
            report($exception);
        }
    }
}
