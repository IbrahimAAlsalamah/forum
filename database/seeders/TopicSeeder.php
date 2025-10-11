<?php

namespace Database\Seeders;

use App\Models\Topic;
use Illuminate\Database\Seeder;

class TopicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'slug' => 'general',
                'name' => 'General',
                'description' => 'Any and all things about films and movies.',
            ],
            [
                'slug' => 'reviews',
                'name' => 'Reviews',
                'description' => 'What’s the consensus on that latest flick? Read all about it here!',
            ],
            [
                'slug' => 'directors',
                'name' => 'Directors',
                'description' => 'Discuss your favorite filmmakers and their works.',
            ],
            [
                'slug' => 'trailers',
                'name' => 'Trailers',
                'description' => 'Talk about the newest movie trailers and teasers.',
            ],
            [
                'slug' => 'awards',
                'name' => 'Awards',
                'description' => 'Predictions, reactions, and coverage of film awards.',
            ],
            [
                'slug' => 'box-office',
                'name' => 'Box Office',
                'description' => 'Follow movie earnings, records, and weekend charts.',
            ],
            [
                'slug' => 'recommendations',
                'name' => 'Recommendations',
                'description' => 'Share and discover must-watch films across genres.',
            ],
        ];

        Topic::upsert($data, ['slug']);
    }
}
