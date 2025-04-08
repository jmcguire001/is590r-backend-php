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
        Schema::dropIfExists('conference_divisions');
        Schema::create('conference_divisions', function (Blueprint $table) {
            $table->primary(['confId', 'divId']); // Composite PK
            $table->foreignId('confId')->constrained('conferences')->onDelete('cascade');
            $table->foreignId('divId')->constrained('divisions')->onDelete('cascade');
            $table->timestamps();
        });        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conference_divisions');
    }
};
