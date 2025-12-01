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
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->foreignId('scope_id')->nullable()->constrained('scopes')->cascadeOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('body');
            $table->string('pdf')->nullable();
            $table->string('image');
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->boolean('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};

