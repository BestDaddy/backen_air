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
        Schema::create('arduino_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('class');
        });

        Schema::create('arduino', function (Blueprint $table) {
            $table->id();
            $table->foreignId('type_id')->constrained('arduino_types')->onDelete('CASCADE');
            $table->string('name', '255');
            $table->ipAddress('ip')->unique();
            $table->ipAddress('token')->nullable();
            $table->json('config')->nullable();
            $table->timestamp('expired_at')->nullable();
            $table->timestamp('last_seen_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('arduino');
        Schema::dropIfExists('arduino_types');
    }
};
