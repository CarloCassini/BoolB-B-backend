<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Apartment;
use App\Models\Visualization;


use Faker\Generator as faker;

class VisualizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        // making 50 fake visualization
        for ($i = 0; $i < 50; $i++) {

            $visualization = new visualization();

            // Ottieni un id valido dalla tabella apartments
            $apartmentId = Apartment::inRandomOrder()->first()->id;

            $visualization->apartment_id = $apartmentId;

            //* set the datetime 
            $visualization->date = $faker->date() . ' ' . $faker->time();

            //* get the ip adress from request
            $visualization->ip = $faker->ipv4();

            $visualization->save();
        }


    }
}
