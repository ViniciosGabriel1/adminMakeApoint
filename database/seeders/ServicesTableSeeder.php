<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ServicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        // Vamos adicionar 10 serviços de exemplo
        for ($i = 0; $i < 10; $i++) {
            DB::table('services')->insert([
                'user_id' => 2,
                'title' => $faker->company,  // Gerando um nome de empresa como título
                'value' => $faker->randomFloat(2, 10, 1000),  // Gerando um valor de serviço entre 10 e 1000 com 2 casas decimais
                'description' => $faker->sentence,  // Gerando uma descrição aleatória
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
