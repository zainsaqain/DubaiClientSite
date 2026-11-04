<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankTransferSetting extends Model
{
    protected $fillable = ['bank_name', 'account_holder_name', 'iban', 'account_number', 'swift_bic', 'currency', 'payment_instructions', 'is_enabled'];

    protected function casts(): array
    {
        return ['is_enabled' => 'boolean'];
    }
}
