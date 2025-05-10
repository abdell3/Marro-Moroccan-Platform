<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE polls MODIFY COLUMN typeVote ENUM('standard', 'etoiles', 'pouces', 'single', 'multiple', 'updown', 'rating') DEFAULT 'standard'");
        DB::table('polls')->where('typeVote', 'single')->update(['typeVote' => 'standard']);
        DB::table('polls')->where('typeVote', 'multiple')->update(['typeVote' => 'standard']);
        DB::table('polls')->where('typeVote', 'updown')->update(['typeVote' => 'pouces']);
        DB::table('polls')->where('typeVote', 'rating')->update(['typeVote' => 'etoiles']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('polls')->where('typeVote', 'standard')->update(['typeVote' => 'single']);
        DB::table('polls')->where('typeVote', 'pouces')->update(['typeVote' => 'updown']);
        DB::table('polls')->where('typeVote', 'etoiles')->update(['typeVote' => 'rating']);
        DB::statement("ALTER TABLE polls MODIFY COLUMN typeVote ENUM('single', 'multiple', 'updown', 'rating') DEFAULT 'single'");
    }
};
