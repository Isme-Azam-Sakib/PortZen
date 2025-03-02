<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Template;

class TemplateSeeder extends Seeder
{
    public function run()
    {
        Template::create([
            'name' => 'Modern Portfolio',
            'description' => 'A clean, modern design perfect for developers',
            'thumbnail' => 'images/templates/ellesi1.png',
            'file' => 'templates/modern-template.blade.php',
        ]);

        Template::create([
            'name' => 'Creative Portfolio',
            'description' => 'Ideal for designers and artists',
            'thumbnail' => 'images/templates/ellesi2.png',
            'file' => 'templates/creative-template.blade.php',
        ]);
    }
} 