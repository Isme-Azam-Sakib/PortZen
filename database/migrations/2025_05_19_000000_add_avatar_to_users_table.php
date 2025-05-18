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
        Schema::table('users', function (Blueprint $table) {
            $table->string('avatar')->nullable()->after('email');
            $table->string('phone')->nullable()->after('avatar');
            $table->text('bio')->nullable()->after('phone');
            $table->string('location')->nullable()->after('bio');
            $table->string('website')->nullable()->after('location');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['avatar', 'phone', 'bio', 'location', 'website']);
        });
    }
}; 