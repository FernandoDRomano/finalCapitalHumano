<?php

use App\Organizacion;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call(SistemaTableSeeder::class);
    }

}
