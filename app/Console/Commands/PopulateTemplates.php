<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Template;
use Illuminate\Support\Facades\DB;

class PopulateTemplates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'templates:populate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Populate the templates table with sample templates';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Populating templates table...');
        
        // Template data
        $templates = [
            [
                'name' => 'Modern Portfolio',
                'description' => 'A clean and modern design perfect for showcasing your work with style.',
                'thumbnail' => 'images/templates/modern-template.jpg',
                'is_active' => true,
            ],
            [
                'name' => 'Creative Portfolio',
                'description' => 'An artistic and dynamic layout that makes your portfolio stand out.',
                'thumbnail' => 'images/templates/creative-template.jpg',
                'is_active' => true,
            ],
            [
                'name' => 'Professional Portfolio',
                'description' => 'A sophisticated design focused on professional achievements.',
                'thumbnail' => 'images/templates/professional-template.jpg',
                'is_active' => true,
            ],
            [
                'name' => 'Minimal Portfolio',
                'description' => 'A clean, minimalist design that puts your work front and center.',
                'thumbnail' => 'images/templates/minimal-template.jpg',
                'is_active' => true,
            ],
            [
                'name' => 'Designer Portfolio',
                'description' => 'A visually rich template ideal for designers and creatives.',
                'thumbnail' => 'images/templates/designer-template.jpg',
                'is_active' => true,
            ],
            [
                'name' => 'Developer Portfolio',
                'description' => 'A tech-focused template perfect for developers to showcase projects and skills.',
                'thumbnail' => 'images/templates/developer-template.jpg',
                'is_active' => true,
            ],
        ];
        
        $created = 0;
        $updated = 0;
        
        foreach ($templates as $templateData) {
            // Check if template with this name already exists
            $template = Template::where('name', $templateData['name'])->first();
            
            if ($template) {
                // Update existing template
                $template->update($templateData);
                $updated++;
                $this->info("Updated template: {$templateData['name']}");
            } else {
                // Create new template
                Template::create($templateData);
                $created++;
                $this->info("Created template: {$templateData['name']}");
            }
        }
        
        $this->info("Templates populated successfully: {$created} created, {$updated} updated");
        
        return 0;
    }
} 