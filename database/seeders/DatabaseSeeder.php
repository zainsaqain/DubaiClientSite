<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $this->call([
            DesertAdventureSeeder::class,
            SportsEventSeeder::class,
            CruiseBoatTourSeeder::class,
            AttractionSeeder::class,
            CityTourSeeder::class,
            WaterparkThemeParkSeeder::class,
            TransferSeeder::class,
            WhyUsFeatureSeeder::class,
            HeroSlideSeeder::class,
            HomePromoCardSeeder::class,
            HomeSignatureJourneySeeder::class,
            HomeTestimonialSeeder::class,
            TourManagementSeeder::class,
        ]);
    }
}
