<?php

use Illuminate\Database\Seeder;
use \App\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                "name" => "Ravi Malik",
                "email" => "ravimalik2364@gmail.com",
                "password" => \Hash::make("password")
            ],
        ];

        User::insert($data);
    }
}
