<?php

namespace Database\Seeders;

use App\Models\TourCategory;
use App\Models\TourCategoryContentBlock;
use App\Models\TourCategoryFaq;
use Illuminate\Database\Seeder;

class CategoryPageContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'desert-adventures' => ['description' => 'Explore desert safaris, dune buggies, desert experiences and school trips across Dubai.', 'image' => 'tour-categories/desert-adventures-ai.png'],
            'attractions' => ['description' => 'Discover Dubai attractions and entry experiences, from iconic viewpoints to family favourites.', 'image' => 'tour-categories/attractions-ai.png'],
            'sports-events' => ['description' => 'Browse sports and event experiences across Dubai and the UAE.', 'image' => 'tour-categories/sports-events-ai.png'],
            'city-tours' => ['description' => 'See Dubai and nearby destinations through thoughtfully planned city tours.', 'image' => 'tour-categories/city-tours-ai.png'],
            'cruise-and-boat-tours' => ['description' => 'Explore Dubai from the water with marina, creek and private boat experiences.', 'image' => 'tour-categories/cruise-and-boat-tours-ai.png'],
            'waterparks-theme-parks' => ['description' => 'Plan waterpark and theme park days for families, friends and groups.', 'image' => 'tour-categories/waterparks-theme-parks-ai.png'],
            'transfers' => ['description' => 'Arrange private airport and intercity transfers across Dubai and the UAE.', 'image' => 'tour-categories/transfers-ai.png'],
        ];

        foreach ($categories as $slug => $content) {
            $category = TourCategory::query()->where('slug', $slug)->first();

            if (! $category) {
                continue;
            }

            $category->fill([
                'description' => $category->description ?: $content['description'],
                'image' => $category->image ?: $content['image'],
                'meta_title' => $category->meta_title ?: $category->name.' | Waheed Murad Tourism',
                'meta_description' => $category->meta_description ?: $content['description'],
            ])->save();
        }

        $desertCategory = TourCategory::query()->where('slug', 'desert-adventures')->first();

        if (! $desertCategory) {
            return;
        }

        foreach ([
            ['heading' => 'An award-winning team of desert experts', 'body' => 'Our experienced desert team creates memorable journeys for visitors, whether they are looking for adventure, culture or time in the open landscape.', 'image' => 'images/desert-safari.png', 'image_alt' => 'Desert guides together', 'layout' => 'image_left', 'display_order' => 1],
            ['heading' => 'The Dubai Desert Conservation Reserve', 'body' => 'The protected desert landscape offers a distinctive setting for desert experiences, with native wildlife, open dunes and a welcome break from the city.', 'image' => 'images/desert-oasis-morning.png', 'image_alt' => 'Wildlife in the desert', 'layout' => 'image_right', 'display_order' => 2],
            ['heading' => 'A commitment to the desert', 'body' => 'Thoughtful desert experiences can help visitors connect with the landscape while respecting the natural environment and local heritage.', 'image' => 'images/desert-dune-drive.png', 'image_alt' => 'Desert sunset journey', 'layout' => 'image_left', 'display_order' => 3],
        ] as $block) {
            TourCategoryContentBlock::query()->firstOrCreate(
                ['tour_category_id' => $desertCategory->id, 'heading' => $block['heading']],
                $block + ['is_active' => true],
            );
        }

        foreach ([
            ['question' => 'Where is the desert in Dubai?', 'answer' => 'Dubai has accessible desert landscapes outside the city, including protected areas and wide dune terrain.', 'display_order' => 1],
            ['question' => 'Can I go to the Dubai desert on my own?', 'answer' => 'Guided experiences can help visitors explore the desert with planned routes and local support.', 'display_order' => 2],
            ['question' => 'Is it cooler in the desert in Dubai?', 'answer' => 'Morning and evening experiences are popular choices for visitors who prefer milder parts of the day.', 'display_order' => 3],
            ['question' => 'Why is the Dubai desert famous?', 'answer' => 'The desert is known for its dunes, wildlife, cultural traditions and contrast with the city skyline.', 'display_order' => 4],
        ] as $faq) {
            TourCategoryFaq::query()->firstOrCreate(
                ['tour_category_id' => $desertCategory->id, 'question' => $faq['question']],
                $faq + ['is_active' => true],
            );
        }
    }
}
