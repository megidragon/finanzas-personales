<?php

use App\Movements;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(TestUsersSeeder::class);
        $this->call(BasicDataSeeder::class);

        factory(Movements::class, 600)->create();
    }
}
