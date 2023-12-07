<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Sponsor;

class SponsorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $_sponsors = [
          [
            "price" => 2.99,
            "time" => 24,
            "name" => " Standard sponsorship", 
          ],
          [
            "price" => 5.99,
            "time" => 72,
            "name" => " Gold sponsorship", 
          ],
          [
            "price" => 9.99,
            "time" => 144,
            "name" => " Premium sponsorship", 
          ],     
        ];

        foreach ($_sponsors as $_sponsor) {
            $sponsor = new Sponsor();

            $sponsor->price = $_sponsor["price"];
            $sponsor->time = $_sponsor["time"];
            $sponsor->name = $_sponsor["name"];

            $sponsor->save();
        }
    }
}
