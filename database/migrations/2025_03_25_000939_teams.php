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
        Schema::dropIfExists(table:'teams');
        Schema::create(table:'teams',callback:function(Blueprint $table): void {
            $table->id();
            $table->string(column:'teamName');
            $table->string(column:'teamAbbr');
            $table->string(column:'teamLogo');
            $table->string(column:'teamConference');
            $table->string(column:'teamDivision');
            $table->string(column:'teamCity');
            $table->string(column:'teamState');
            $table->string(column:'teamCountry');
            $table->string(column:'teamStadium');
            $table->string(column:'teamMascot');
            $table->timestamp(column:'created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(table:'teams');
    }
};
