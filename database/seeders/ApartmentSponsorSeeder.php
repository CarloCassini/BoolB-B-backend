<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

//importo i modelli
use App\Models\Apartment;
use App\Models\Sponsor;

//importo faker
use Faker\Generator as Faker;

class ApartmentSponsorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $apartments = Apartment::all();                       
        $sponsors = Sponsor::all()->pluck('id')->toArray(); 
    
        // Array di end date per sponsor specifici
        $endDateForSponsor = [
            1 => now()->addDays(1)->format('Y-m-d H:i:s'), // Sponsor 1: 1 giorno dopo la data di inizio
            2 => now()->addDays(3)->format('Y-m-d H:i:s'), // Sponsor 2: 3 giorni dopo la data di inizio
            3 => now()->addDays(6)->format('Y-m-d H:i:s'), // Sponsor 3: 6 giorni dopo la data di inizio
        ];
    
        foreach($apartments as $apartment) {
            $numberOfSponsors = random_int(0, 1); // Numero casuale di sponsor da associare
            $randomSponsors = $faker->randomElements($sponsors, $numberOfSponsors);
            
            // Estrai solo gli ID degli sponsor casuali
            $sponsorIds = array_slice($randomSponsors, 0, $numberOfSponsors);
    
            foreach ($sponsorIds as $sponsorId) {
                // Ottieni la data di fine specifica per lo sponsor
                $endDate = $endDateForSponsor[$sponsorId] ?? null;
    
                // Verifica se la data di fine è stata definita per lo sponsor
                if ($endDate !== null) {
                    $apartment->sponsors()->attach($sponsorId, [
                        'start_date' => now(),
                        'end_date' => $endDate,
                    ]);
                }
            }
            $apartment->save();
        }
    }
}

