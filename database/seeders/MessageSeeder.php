<?php

namespace Database\Seeders;

use App\Models\Message;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MessagesTableSeeder extends Seeder
{
    public function run()
    {
        foreach (config('bnb.messages') as $message) {
            $newMessage = new Message();

            $newMessage->apartment_id = $message["apartment_id"];
            $newMessage->email_sender = $message["sender_e-mail"];
            $newMessage->text_message = $message["message"];
            

            $newMessage->save();
        }
    }
}
