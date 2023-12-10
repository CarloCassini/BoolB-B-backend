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
                'label' => "Parking slot",
                'symbol' => "fa-solid fa-car",
            ],
            [
                'label' => "Pool",
                'symbol' => "fa-solid fa-person-swimming",
            ],
            [
                'label' => "Concierge",
                'symbol' => "fa-solid fa-bell-concierge",
            ],
            [
                'label' => "Sauna",
                'symbol' => "fa-solid fa-bath",
            ],
            [
                'label' => "Sea view",
                'symbol' => "fa-solid fa-water",
            ],
            [
                'label' => "Public transport Near-by",
                'symbol' => "fa-solid fa-train",
            ],
            [
                'label' => "Proximity to the center",
                'symbol' => "fa-solid fa-location-crosshairs",
            ],
            [
                'label' => "Gym",
                'symbol' => "fa-solid fa-dumbbell",
            ],
            [
                'label' => "Breakfast Service",
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