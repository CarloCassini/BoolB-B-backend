<?php

namespace Database\Seeders;

use App\Models\Apartment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

// uso Faker
use Faker\Generator as Faker;

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

        // creo 10 appartamenti distribuiti casualmente tra gli utenti registrati
        for ($i = 0; $i < 10; $i++) {
            $apartment = new Apartment();
            $apartment->title = $faker->sentence(3);
            $apartment->rooms = $faker->numberBetween(1, 255);
            $apartment->beds = $faker->numberBetween(1, 255);
            $apartment->bathrooms = $faker->numberBetween(1, 255);
            $apartment->m2 = $faker->numberBetween(20, 5000);
            $apartment->is_hidden = $faker->numberBetween(0, 1);
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
            $apartment->latitude_int = $faker->latitude($min = -90, $max = 90) * (10 * 6);
            $apartment->longitude_int = $faker->longitude($min = -180, $max = 180) * (10 * 6);


            // al momento uso solo l'utente 1
            $apartment->user_id = 1;

            $apartment->save();
        }
    }
}