<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone', 30);
            $table->enum('status', ['new', 'contacted', 'converted'])->default('new');
            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();

            $table->index('status');
            $table->index('assigned_to');
        });
    }

   
    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
