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
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('resident_id')->constrained('residents')->onUpdate('cascade')->onDelete('cascade');
            $table->date('payment_date')->comment('تمدید قرارداد');
            $table->foreignId('bed_id')->constrained('beds')->onDelete('cascade');
            $table->enum('state', ['rezerve', 'nightly', 'active', 'leaving', 'exit']);
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
};
