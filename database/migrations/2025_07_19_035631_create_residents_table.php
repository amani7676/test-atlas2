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
        Schema::create('residents', function (Blueprint $table) {
             $table->id();
            $table->string('full_name');
            $table->string('phone');
            $table->bigInteger('age');
            $table->string('job');
            $table->enum('referral_source', [
                'university_introduction',
                'university_website',
                'google',
                'map',
                'khobinja_website',
                'introducing_friends',
                'street',
                'divar',
                'other'
            ])->comment('نحوه اشنایی');
            $table->boolean('form');
            $table->boolean('rent');
            $table->boolean('trust');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('residents');
    }
};
