<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BankTransferPayment extends Model
{
    protected $fillable = ['booking_id', 'transaction_reference', 'payment_date', 'screenshot_path', 'status', 'submitted_at', 'verified_at', 'verified_by', 'rejection_reason', 'admin_note'];

    protected function casts(): array
    {
        return ['payment_date' => 'date', 'submitted_at' => 'datetime', 'verified_at' => 'datetime'];
    }

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    public function verifier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }
}
