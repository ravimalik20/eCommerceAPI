<?php

use Illuminate\Database\Seeder;

use App\Models\Status;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ["name" => "created"],
            ["name" => "approved" ]
        ];

        Status::insert($data);
    }
}
