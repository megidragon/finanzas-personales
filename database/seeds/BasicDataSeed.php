<?php

use Illuminate\Database\Seeder;

class BasicDataSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Alta de monedas basicas
        DB::table('currencies')->insert([
            'name' => 'Peso',
            'symbol' => 'ARS'
        ]);
        DB::table('currencies')->insert([
            'name' => 'Dolar',
            'symbol' => 'U$S'
        ]);

        // Alta de categorias basicas
        DB::table('categories')->insert([
            'name' => 'Mercado',
        ]);

        DB::table('categories')->insert([
            'name' => 'Sueldo',
        ]);

        DB::table('categories')->insert([
            'name' => 'Freelance',
        ]);

        DB::table('categories')->insert([
            'name' => 'AWS',
        ]);

        DB::table('categories')->insert([
            'name' => 'Transporte',
        ]);
    }
}
