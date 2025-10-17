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
        Schema::create('prompts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('raw_prompt');
            $table->longText('optimized_prompt')->nullable();
            $table->enum('language',['english','spanish','french','german','chinese','japanese','hindi','bengali'])->default('english');
            $table->enum('output_format',['text','json'])->default('text');

            $table->integer('views_count')->default(0);
            $table->integer('copies_count')->default(0);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_approved')->default(true);
            $table->boolean('is_public')->default(true);
            $table->timestamps();

            $table->index(['user_id', 'created_at']);
            $table->index(['category_id', 'created_at']);
            $table->index(['is_featured', 'is_approved']);
 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prompts');
    }
};
