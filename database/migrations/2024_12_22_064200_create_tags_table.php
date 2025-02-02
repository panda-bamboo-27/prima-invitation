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
        Schema::create('tags', function (Blueprint $table) {
            $table->bigInteger('theme_id')->unsigned();
            $table->bigInteger('tag_id')->unsigned();
            $table->timestamps();

            $table->foreign('theme_id')->references('id')->on('themes');
            $table->foreign('tag_id')->references('id')->on('theme_tags');
            $table->unique(['theme_id', 'tag_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tags');
    }
};
