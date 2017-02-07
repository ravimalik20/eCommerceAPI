<?php

use Illuminate\Database\Seeder;

class UserRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ["name" => "admin"],
            ["name" => "user"]
        ];

        \DB::table("user_roles")->insert($data);
    }
}
