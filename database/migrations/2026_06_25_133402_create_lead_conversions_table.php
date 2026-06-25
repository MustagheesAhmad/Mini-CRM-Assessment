<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  
    public function up(): void
    {
        Schema::create('lead_conversions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lead_id')->constrained('leads')->cascadeOnDelete();
            $table->string('lead_name');
            $table->foreignId('converted_by')->constrained('users');
            $table->timestamp('converted_at');
            $table->timestamp('created_at')->nullable();

            $table->index('lead_id');
        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('lead_conversions');
    }
};
