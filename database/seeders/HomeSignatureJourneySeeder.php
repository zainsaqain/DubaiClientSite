<?php

namespace Database\Seeders;

use App\Models\HomeSignatureJourney;
use Illuminate\Database\Seeder;

class HomeSignatureJourneySeeder extends Seeder
{
    public function run(): void
    {
        $journey = ['badge' => 'WMT SELECT', 'caption' => 'Dubai, beyond the ordinary', 'eyebrow' => 'DESIGNED FOR THE WAY YOU TRAVEL', 'title' => 'More than a booking.', 'highlight' => 'A Dubai memory.', 'description' => 'From a sunrise across the dunes to a city evening made just for you, our local team turns simple plans into standout moments.', 'point_one' => 'Local experts, thoughtful details', 'point_two' => 'Flexible plans for every pace', 'point_three' => 'Support from first message to last stop', 'button_label' => 'Plan your experience', 'button_url' => '#booking', 'image' => 'images/camel-desert-journey.png', 'display_order' => 1, 'is_active' => true];
        HomeSignatureJourney::query()->updateOrCreate(['title' => $journey['title']], $journey);
    }
}
