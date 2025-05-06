<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('story_progressions')) {
            Schema::create('story_progressions', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->foreignId('story_id')->constrained()->onDelete('cascade');
                $table->foreignId('current_chapter_id')->constrained('chapters');
                $table->timestamps();
                
                // Un utilisateur ne peut avoir qu'une seule progression par histoire
                $table->unique(['user_id', 'story_id']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('story_progressions');
    }
};