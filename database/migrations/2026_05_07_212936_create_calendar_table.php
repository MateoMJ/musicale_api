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
        Schema::create('calendars', function (Blueprint $table) {
            $table->id();
            $table->string('date_string');
            $table->integer('day');
            $table->integer('month');
            $table->integer('year');
            $table->boolean('is_weekday');
            $table->boolean('is_business_day');
            $table->boolean('is_holiday');
            $table->string('holiday_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calendars');
    }
};
