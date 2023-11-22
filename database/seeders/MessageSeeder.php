<?php

namespace Database\Seeders;

use App\Models\Message;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

// uso Faker
use Faker\Generator as Faker;

class MessageSeeder extends Seeder
{
    public function run(Faker $faker)
    {
        for ($i = 0; $i < 10; $i++) {
            $newMessage = new Message();
            $newMessage->sender_email = $faker->email();
            $newMessage->message = $faker->paragraph(2);
            $newMessage->name = $faker->firstName();
            $newMessage->surname = $faker->lastName();

            // arbitrariamente messaggi solo su appartamento 1
            $newMessage->apartment_id = 1;

            $newMessage->save();
        }
    }
}