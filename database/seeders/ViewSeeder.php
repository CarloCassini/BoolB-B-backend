<?php

namespace Database\Seeders;

use App\Models\Apartment;
use App\Models\View;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Faker\Generator as faker;

class ViewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        // making 50 fake visualization
        for ($i=0; $i < 50 ; $i++) { 
            
            $view = new View();

            // Ottieni un id valido dalla tabella apartments
            $apartmentId = Apartment::inRandomOrder()->first()->id;

            $view->apartment_id = $apartmentId;
    
            //* set the datetime 
            $view->date = $faker->date().' '. $faker->time();
            
            //* get the ip adress from request
            $view->ip = $faker->ipv4();
    
            $view->save();
        }


    }
}
