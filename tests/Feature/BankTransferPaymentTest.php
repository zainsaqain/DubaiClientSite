<?php

namespace Tests\Feature;

use App\Models\BankTransferPayment;
use App\Models\BankTransferSetting;
use App\Models\Booking;
use App\Models\Tour;
use App\Models\TourCategory;
use App\Models\TourPrice;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Tests\TestCase;

class BankTransferPaymentTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_can_create_a_bank_transfer_order_and_submit_payment_details(): void
    {
        Storage::fake('local');
        $user = User::factory()->create();
        $tour = $this->activeTour();
        $price = TourPrice::query()->create(['tour_id' => $tour->id, 'vehicle_type' => 'shared', 'adult_price' => 150, 'child_price' => 75, 'currency' => 'AED', 'is_active' => true]);
        BankTransferSetting::query()->create(['bank_name' => 'Emirates NBD', 'account_holder_name' => 'Waheed Murad Tourism', 'iban' => 'AE070331234567890123456', 'currency' => 'AED', 'is_enabled' => true]);

        $this->actingAs($user)->post(route('checkout.store', $tour), [
            'tour_price_id' => $price->id,
            'travel_date' => now()->addDay()->toDateString(),
            'adults' => 2,
            'children' => 1,
            'infants' => 0,
            'payment_method' => 'direct_bank_transfer',
        ])->assertRedirect();

        $booking = Booking::query()->firstOrFail();
        $this->assertSame('pending_payment', $booking->payment_status);
        $this->assertSame('375.00', $booking->amount);

        $this->actingAs($user)->post(route('bank-transfer.submit', $booking), [
            'transaction_reference' => 'ENBD-123456',
            'payment_date' => now()->toDateString(),
            'screenshot' => UploadedFile::fake()->image('receipt.png'),
        ])->assertRedirect(route('bank-transfer.show', $booking));

        $this->assertDatabaseHas('bank_transfer_payments', ['booking_id' => $booking->id, 'status' => 'pending_verification', 'transaction_reference' => 'ENBD-123456']);
        $this->assertDatabaseHas('bookings', ['id' => $booking->id, 'payment_status' => 'pending_verification']);
    }

    public function test_other_customers_cannot_access_a_payment_submission(): void
    {
        $owner = User::factory()->create();
        $otherUser = User::factory()->create();
        $booking = $this->bookingFor($owner);

        $this->actingAs($otherUser)->get(route('bank-transfer.show', $booking))->assertForbidden();
    }

    public function test_admin_approval_is_idempotent_and_marks_the_booking_paid(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $booking = $this->bookingFor(User::factory()->create());
        $payment = $booking->bankTransferPayment;
        $payment->update(['status' => 'pending_verification', 'transaction_reference' => 'ENBD-123456', 'submitted_at' => now()]);
        $booking->update(['payment_status' => 'pending_verification', 'status' => 'pending_verification']);

        $this->actingAs($admin)->patch(route('admin.bank-transfer-payments.approve', $payment), ['funds_received' => '1'])->assertSessionHas('success');
        $this->actingAs($admin)->patch(route('admin.bank-transfer-payments.approve', $payment->fresh()), ['funds_received' => '1'])->assertSessionHas('success');

        $this->assertDatabaseHas('bank_transfer_payments', ['id' => $payment->id, 'status' => 'paid', 'verified_by' => $admin->id]);
        $this->assertDatabaseHas('bookings', ['id' => $booking->id, 'payment_status' => 'paid', 'status' => 'confirmed']);
        $this->assertDatabaseCount('bank_transfer_payment_audits', 1);
    }

    private function activeTour(): Tour
    {
        $category = TourCategory::query()->create(['name' => 'Attractions', 'slug' => 'attractions', 'is_active' => true]);

        return Tour::query()->create(['tour_category_id' => $category->id, 'name' => 'Dubai Aquarium', 'slug' => 'dubai-aquarium', 'starting_price' => 100, 'currency' => 'AED', 'status' => 'active']);
    }

    private function bookingFor(User $user): Booking
    {
        $tour = $this->activeTour();
        $booking = Booking::query()->create(['user_id' => $user->id, 'tour_id' => $tour->id, 'order_number' => 'WMT-TEST-'.Str::random(6), 'travel_date' => now()->addDay(), 'adults' => 1, 'amount' => 100, 'currency' => 'AED', 'payment_method' => 'direct_bank_transfer']);
        BankTransferPayment::query()->create(['booking_id' => $booking->id]);

        return $booking->load('bankTransferPayment');
    }
}
