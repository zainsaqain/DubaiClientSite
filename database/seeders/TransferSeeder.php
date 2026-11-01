<?php

namespace Database\Seeders;

use App\Models\Transfer;
use Illuminate\Database\Seeder;

class TransferSeeder extends Seeder
{
    public function run(): void
    {
        $transfers = [
            ['title' => 'Dubai Airport Private Transfer', 'transfer_type' => 'Airport service', 'description' => 'Meet your professional driver on arrival and travel comfortably from Dubai International Airport to your hotel or destination.', 'location' => 'Dubai & UAE', 'price' => 9618, 'image' => 'images/airport-transfer.png', 'is_featured' => true],
            ['title' => 'Private Intercity Transfer', 'transfer_type' => 'Door to door', 'description' => 'A reliable private journey for your plans beyond Dubai, with flexible pickup and room for your travel essentials.', 'location' => 'Dubai & UAE', 'price' => 35560, 'image' => 'images/dubai-adventure.png', 'is_featured' => true],
        ];

        foreach ($transfers as $transfer) {
            Transfer::query()->updateOrCreate(['title' => $transfer['title']], [...$transfer, 'is_active' => true]);
        }
    }
}
