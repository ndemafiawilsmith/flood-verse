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
        Schema::create('victims', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('age')->nullable();
            $table->string('gender')->nullable(); // male/female/other
            $table->string('contact')->nullable(); // phone number
            $table->string('location')->nullable(); // community, e.g. Atani
            $table->decimal('latitude', 10, 7)->nullable();   // e.g. 6.5244
            $table->decimal('longitude', 10, 7)->nullable();  // e.g. 3.3792
            $table->unsignedBigInteger('safe_zone_id')->nullable(); // link to SafeZonie
            $table->timestamps();

            $table->foreign('safe_zone_id')->references('id')->on('safe_zones')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('victims');
    }
};
