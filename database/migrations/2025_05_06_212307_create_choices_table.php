_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('choices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('chapter_id')->constrained()->onDelete('cascade');
            $table->foreignId('next_chapter_id')->constrained('chapters')->onDelete('cascade');
            $table->string('text');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('choices');
    }
};