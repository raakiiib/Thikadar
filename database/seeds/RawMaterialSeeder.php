<?php

namespace Database\Seeders;

use App\Models\RawMaterial;
use Illuminate\Database\Seeder;

class RawMaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(RawMaterial::class, 20)->create([
            'product_name' => Str::random(10),
            'unit' => Str::random(5),
            'description' => Str::random(200),
        ]);
    }
}
