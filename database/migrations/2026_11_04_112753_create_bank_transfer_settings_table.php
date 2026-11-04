<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bank_transfer_settings', function (Blueprint $table) {
            $table->id();
            $table->string('bank_name')->default('Emirates NBD');
            $table->string('account_holder_name');
            $table->string('iban');
            $table->string('account_number')->nullable();
            $table->string('swift_bic')->nullable();
            $table->string('currency', 8)->default('AED');
            $table->text('payment_instructions')->nullable();
            $table->boolean('is_enabled')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bank_transfer_settings');
    }
};
