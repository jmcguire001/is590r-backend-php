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
            $table->string(column:'name');
            $table->string(column:'abbr');
            $table->string(column:'logo')->nullable();
            $table->integer(column:'confId')->nullable();
            $table->integer(column:'divId')->nullable();
            $table->string(column:'city');
            $table->string(column:'state');
            $table->string(column:'country');
            $table->string(column:'stadium');
            $table->string(column:'mascot')->nullable();
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
