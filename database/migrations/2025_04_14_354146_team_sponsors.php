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
        Schema::dropIfExists('team_sponsors');
        Schema::create('team_sponsors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teamId')->constrained('teams')->onDelete('cascade');
            $table->foreignId('sponsorId')->constrained('sponsors')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('team_sponsors');
    }
};
