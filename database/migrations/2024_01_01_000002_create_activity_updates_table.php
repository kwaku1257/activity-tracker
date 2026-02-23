<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activity_updates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('activity_id')->constrained('activities')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->enum('old_status', ['pending', 'done'])->nullable(); // null on first creation
            $table->enum('new_status', ['pending', 'done']);
            $table->text('remarks')->nullable();
            $table->timestamps();
            
            // indexes for faster queries on daily view and reports
            $table->index(['activity_id', 'created_at']);
            $table->index('user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_updates');
    }
};
