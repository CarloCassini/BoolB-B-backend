<?php

namespace Database\Seeders;

use App\Models\Apartment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

// uso Faker
use Faker\Generator as Faker;

// chiamo la tabella dei servizi
use App\Models\Service;

// importo gli user
use App\Models\User;

class ApartmentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {


        $services = Service::all()->pluck('id');
        // creo 100 appartamenti distribuiti casualmente tra gli utenti registrati
        for ($i = 0; $i < 10; $i++) {


            $apartment = new Apartment();
            $apartment->title = $faker->sentence(3);
            $apartment->rooms = $faker->numberBetween(1, 255);
            $apartment->beds = $faker->numberBetween(1, 255);
            $apartment->bathrooms = $faker->numberBetween(1, 255);
            $apartment->m2 = $faker->numberBetween(20, 5000);
            $apartment->is_hidden = $faker->boolean();
            $apartment->address = $faker->address();
            $apartment->description = $faker->paragraph(5);

            // inserisco una immagine si e una no a tutti gli appartamenti.
            // da rivedere quando ci sarà la tabella foto
            if ($i % 2 == 0) {
                $apartment->cover_image_path = $faker->imageUrl(640, 480, 'Apartment', true);
            } else {
                $apartment->cover_image_path = null;
            }

            // ho ancora dei dubbi sulla gestione longitudine latitudine
            $apartment->latitude = $faker->latitude($min = 41.5902, $max = 42.2000);
            $apartment->longitude = $faker->longitude($min = 12.2000, $max = 13.5931);

            // al momento uso solo l'utente 1
            $apartment->user_id = 1;

            $apartment->save();
            // collego un servizio
            $apartment->services()->attach($faker->randomElements($services));
        }
    }
}