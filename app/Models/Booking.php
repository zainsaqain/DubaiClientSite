<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Booking extends Model
{
    protected $fillable = ['user_id', 'tour_id', 'tour_price_id', 'order_number', 'travel_date', 'adults', 'children', 'infants', 'amount', 'currency', 'payment_method', 'payment_status', 'status'];

    protected function casts(): array
    {
        return ['travel_date' => 'date', 'amount' => 'decimal:2'];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tour(): BelongsTo
    {
        return $this->belongsTo(Tour::class);
    }

    public function price(): BelongsTo
    {
        return $this->belongsTo(TourPrice::class, 'tour_price_id');
    }

    public function bankTransferPayment(): HasOne
    {
        return $this->hasOne(BankTransferPayment::class);
    }
}
