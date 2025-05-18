<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('work_experiences', function (Blueprint $table) {
            // Rename 'position' column to 'job_title'
            $table->renameColumn('position', 'job_title');
            
            // Rename 'description' column to 'responsibilities'
            $table->renameColumn('description', 'responsibilities');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('work_experiences', function (Blueprint $table) {
            // Reverse the changes
            $table->renameColumn('job_title', 'position');
            $table->renameColumn('responsibilities', 'description');
        });
    }
};
