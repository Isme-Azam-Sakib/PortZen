<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Template;
use Illuminate\Support\Facades\DB;

class TemplatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Clear existing templates
        DB::table('templates')->truncate();
        
        // Create templates
        $templates = [
            [
                'name' => 'Modern Portfolio',
                'description' => 'A clean and modern design perfect for showcasing your work with style.',
                'thumbnail' => 'templates/modern-template.jpg',
                'is_active' => true,
            ],
            [
                'name' => 'Creative Portfolio',
                'description' => 'An artistic and dynamic layout that makes your portfolio stand out.',
                'thumbnail' => 'templates/creative-template.jpg',
                'is_active' => true,
            ],
            [
                'name' => 'Professional Portfolio',
                'description' => 'A sophisticated design focused on professional achievements.',
                'thumbnail' => 'templates/professional-template.jpg',
                'is_active' => true,
            ],
            [
                'name' => 'Minimal Portfolio',
                'description' => 'A clean, minimalist design that puts your work front and center.',
                'thumbnail' => 'templates/minimal-template.jpg',
                'is_active' => true,
            ],
            [
                'name' => 'Designer Portfolio',
                'description' => 'A visually rich template ideal for designers and creatives.',
                'thumbnail' => 'templates/designer-template.jpg',
                'is_active' => true,
            ],
            [
                'name' => 'Developer Portfolio',
                'description' => 'A tech-focused template perfect for developers to showcase projects and skills.',
                'thumbnail' => 'templates/developer-template.jpg',
                'is_active' => true,
            ],
            [
                'name' => 'Photographer Portfolio',
                'description' => 'A template optimized for high-resolution images and photo galleries.',
                'thumbnail' => 'templates/photographer-template.jpg',
                'is_active' => true,
            ],
            [
                'name' => 'Writer Portfolio',
                'description' => 'A content-focused template perfect for writers and content creators.',
                'thumbnail' => 'templates/writer-template.jpg',
                'is_active' => true,
            ],
        ];
        
        foreach ($templates as $template) {
            Template::create($template);
        }
    }
} 