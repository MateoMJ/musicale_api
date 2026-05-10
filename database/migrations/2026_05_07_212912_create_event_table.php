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
        Schema::create('events', function (Blueprint $table) {
            $table->uuid()->primary();
            $table->string('name');
            $table->string('description');
            $table->string('event_type');
            $table->string('location');
            $table->time('hour');
            $table->timestamps();

            $table->foreignUuid('user_uuid')->references('uuid')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
