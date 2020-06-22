<?php

use Illuminate\Database\Seeder;
use App\Clients;
use App\User;

class TestUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Alta de usuario admin
        DB::table('users')->insert([
            'email' => 'admin@finanzas.com',
            'password' => Hash::make('test'),
            'is_admin' => true,
        ]);

        // Alta par de clientes para pruebas
        $user = User::create([
            'email' => 'client@finanzas.com',
            'password' => bcrypt('test'),
        ]);
        Clients::create([
            'full_name' => 'Cliente prueba 1',
            'birth_at' => '2000-01-01',
            'profile_image' => null,
            'user_id' => $user->id,
        ]);

        $user = User::create([
            'email' => 'client2@finanzas.com',
            'password' => bcrypt('test'),
        ]);
        Clients::create([
            'full_name' => 'Cliente prueba 2',
            'birth_at' => '2000-01-01',
            'profile_image' => null,
            'user_id' => $user->id,
        ]);
    }
}
