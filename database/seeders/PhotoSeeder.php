<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

// uso Faker
use Faker\Generator as Faker;

use App\Models\Photo;

class PhotoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for ($i = 0; $i < 10; $i++) {
            $photo = new Photo();
            $photo->apartment_id = 2;
            $photo->path = $faker->imageUrl(640, 480, 'Apartment', true);
            $photo->save();
        }
    }
}