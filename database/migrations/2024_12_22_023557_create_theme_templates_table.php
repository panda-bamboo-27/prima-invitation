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
        Schema::create('theme_templates', function (Blueprint $table) {
            $table->id();
            $table->text('template_header')->nullable();
            $table->text('template_content')->nullable();
            $table->integer('version')->default(1);
            $table->integer('theme_id')->index();
            $table->timestamps();
            $table->softDeletes(); // THIS ONE
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('theme_templates');
    }
};
