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
        Schema::create('user_template_variations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('template_id')->constrained('prompt_templates')->onDelete('cascade');
            $table->string('variation_name');
            $table->json('filled_placeholders');
            $table->text('generated_prompt');
            $table->text('optimized_prompt')->nullable();
            $table->boolean('is_favorite')->default(false); 
            $table->timestamps();

            $table->index(['user_id','template_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_template_variations');
    }
};
