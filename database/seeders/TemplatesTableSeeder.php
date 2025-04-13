<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TemplatesTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('templates')->insert([
            [
                'name' => 'Modern Portfolio',
                'description' => 'A clean and modern portfolio template with minimalist design',
                'thumbnail' => 'modern-template.jpg',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Creative Portfolio',
                'description' => 'A creative and colorful portfolio template for artists and designers',
                'thumbnail' => 'creative-template.jpg',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
} 