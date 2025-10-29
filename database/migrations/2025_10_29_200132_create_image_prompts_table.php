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
        Schema::create('image_prompts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->nullable()->constrained()->onDelete('set null');
            $table->string('title'); 
            $table->text('original_description')->nullable();
            $table->longText('optimized_prompt');
            // Image Parameters fields
            $table->string('style')->default('realistic'); 
            $table->string('aspect_ratio')->default('1:1');
            $table->string('mood')->nullable();
            $table->string('lighting')->nullable();
            $table->string('color_paletter')->nullable();
            $table->string('quality_level')->default('standard');

            $table->integer('copies_count')->default(0);
            $table->integer('views_count')->default(0); 
            $table->boolean('is_public')->default(true); 
            $table->timestamps();

            $table->index(['user_id','created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('image_prompts');
    }
};
