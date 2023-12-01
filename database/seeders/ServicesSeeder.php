<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Service;

use Faker\Generator as Faker;

class ServicesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $_services = [
            [
                "label" => "WiFi",
                "symbol" => "fa-solid fa-wifi",
            ],
            [
                'label' => "Posto Macchina",
                'symbol' => "fa-solid fa-car",
            ],
            [
                'label' => "Piscina",
                'symbol' => "fa-solid fa-person-swimming",
            ],
            [
                'label' => "Portineria",
                'symbol' => "fa-solid fa-bell-concierge",
            ],
            [
                'label' => "Sauna",
                'symbol' => "fa-solid fa-bath",
            ],
            [
                'label' => "Vista mare",
                'symbol' => "fa-solid fa-water",
            ],
            [
                'label' => "Accessibilità mezzi pubblici",
                'symbol' => "fa-solid fa-train",
            ],
            [
                'label' => "Vicinanza al centro",
                'symbol' => "fa-solid fa-location-crosshairs",
            ],
            [
                'label' => "Palestra",
                'symbol' => "fa-solid fa-dumbbell",
            ],
            [
                'label' => "Servizio Colazione",
                'symbol' => "fa-solid fa-mug-saucer",
            ],
        ];

        foreach ($_services as $_service) {
            $service = new Service();
            $service->label = $_service["label"];
            $service->color = $faker->hexColor();
            $service->symbol = $_service["symbol"];

            $service->save();
        }
    }
}