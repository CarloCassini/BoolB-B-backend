<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /* 
            name
            surname
            date_of_birth
            email
            password 
        */
        $user = new User();
        $user->name = 'admin';
        $user->surname = 'admin';
        $user->date_of_birth = '2023-11-06';
        $user->email = 'admin@admin.com';
        $user->password = 'password';
        $user->save();
    }
}
