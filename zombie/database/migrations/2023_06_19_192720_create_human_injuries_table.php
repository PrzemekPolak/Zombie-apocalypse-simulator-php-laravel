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
        Schema::create('human_injuries', function (Blueprint $table) {
            $table->id();
            $table->integer('injured_at');
            $table->string('injury_cause');
            $table->unsignedBigInteger('human_id');
            $table->timestamps();
        });

        Schema::table('human_injuries', function (Blueprint $table) {
            $table->foreign('human_id')->references('id')->on('humans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('human_injuries');
    }
};
