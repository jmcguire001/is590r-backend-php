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
        Schema::dropIfExists(table:'conferences');
        Schema::create(table:'conferences',callback:function(Blueprint $table): void {
            $table->id();
            $table->string(column:'name');
            $table->string(column:'abbr');
            $table->boolean(column:'isPower');
            $table->integer(column:'confGames');
            $table->integer(column:'divGames');
            $table->integer(column:'value');
            $table->timestamp(column:'created_at')->useCurrent();
        });   
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
