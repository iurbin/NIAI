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
        Schema::create('notas', function (Blueprint $table) {
            $table->id()->primary();
            $table->string('title');
            $table->string('link');
            $table->string('cover');
            $table->string('extract');
            $table->string('location');
            /* $table->foreignId('city_id');
            $table->foreignId('country_id');
            $table->foreignId('state_id'); */
            $table->timestamps();
        });

        
        
        /* Schema::create('countries', function (Blueprint $table) {
            $table->id('id');
            $table->string('name');
            $table->string('continent');
        });
        Schema::create('states', function (Blueprint $table) {
            $table->id('id');
            $table->string('name');
            $table->foreignId('country_id');
        });
        Schema::create('cities', function (Blueprint $table) {
            $table->id('id');
            $table->string('name');
            $table->foreignId('state_id');
        }); */

        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notas');
    }
};
