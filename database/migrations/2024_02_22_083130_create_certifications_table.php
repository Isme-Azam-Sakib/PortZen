<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('certifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('portfolio_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('institution');
            $table->year('completion_year');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('certifications');
    }
};