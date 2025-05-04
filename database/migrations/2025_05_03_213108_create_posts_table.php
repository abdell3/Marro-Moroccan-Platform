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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->text('contenu')->nullable();
            $table->enum('typeContenu', ['text', 'image', 'video', 'link', 'poll'])->default('text');
            $table->string('media_path')->nullable();
            $table->string('media_type')->nullable();
            $table->timestamp('datePublication')->nullable();
            $table->foreignId('auteur_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('community_id')->constrained()->onDelete('cascade');
            $table->integer('like')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
