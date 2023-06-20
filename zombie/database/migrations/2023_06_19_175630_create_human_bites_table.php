<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('human_bites', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('human_id');
            $table->unsignedBigInteger('zombie_id');
            $table->unsignedBigInteger('turn_id');
            $table->timestamps();
        });

        Schema::table('human_bites', function (Blueprint $table) {
            $table->foreign('human_id')->references('id')->on('humans')->onDelete('cascade');
            $table->foreign('zombie_id')->references('id')->on('zombies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('human_bites');
    }
};
