<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TemplateSeeder extends Seeder
{
    public function run()
    {
        DB::table('templates')->insert([
            [
                'name' => 'Modern Portfolio',
                'description' => 'A clean, modern portfolio template.',
                'thumbnail' => 'images/templates/ellesi1.png',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
} 