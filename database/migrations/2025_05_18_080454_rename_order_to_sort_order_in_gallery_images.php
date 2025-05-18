<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Skip this migration if the gallery_images table doesn't exist
        if (!Schema::hasTable('gallery_images')) {
            return;
        }
        
        // Skip if the 'order' column doesn't exist or 'sort_order' already exists
        if (!Schema::hasColumn('gallery_images', 'order') || 
            Schema::hasColumn('gallery_images', 'sort_order')) {
            return;
        }
        
        Schema::table('gallery_images', function (Blueprint $table) {
            $table->renameColumn('order', 'sort_order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Skip this migration if the gallery_images table doesn't exist
        if (!Schema::hasTable('gallery_images')) {
            return;
        }
        
        // Skip if the 'sort_order' column doesn't exist or 'order' already exists
        if (!Schema::hasColumn('gallery_images', 'sort_order') || 
            Schema::hasColumn('gallery_images', 'order')) {
            return;
        }
        
        Schema::table('gallery_images', function (Blueprint $table) {
            $table->renameColumn('sort_order', 'order');
        });
    }
};
