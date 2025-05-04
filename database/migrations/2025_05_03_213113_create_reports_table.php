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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            
            $table->morphs('reportable');
            
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamp('date')->nullable();
            $table->text('raison')->nullable();
            $table->foreignId('type_report_id')->constrained('report_types')->onDelete('restrict');
            
            $table->timestamp('handled_at')->nullable();
            $table->foreignId('admin_id')->nullable()->constrained('users')->onDelete('set null'); 
            $table->string('action_taken')->nullable();
            $table->text('admin_notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
