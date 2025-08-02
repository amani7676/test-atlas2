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
        Schema::create('cooler_room', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cooler_id')->constrained()->onDelete('cascade');
            $table->foreignId('room_id')->constrained()->onDelete('cascade');
            $table->enum('connection_type', ['direct', 'duct', 'central'])->default('direct');
            $table->date('connected_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique(['cooler_id', 'room_id']); // جلوگیری از ارتباط تکراری
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cooler_room');
    }
};
