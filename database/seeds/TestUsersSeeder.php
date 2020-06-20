<?php

use Illuminate\Database\Seeder;

class TestUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'email' => 'admin@finanzas.com',
            'password' => Hash::make('test'),
            'is_admin' => true,
        ]);
    }
}
