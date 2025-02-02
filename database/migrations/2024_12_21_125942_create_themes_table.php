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
        Schema::create('themes', function (Blueprint $table) {
            $table->id();
            $table->string('theme_name',60);
            $table->string('theme_description',100)->nullable();
            $table->integer('theme_price')->default(0);
            $table->integer('is_active')->default(false);
            $table->integer('theme_category_id')->index();
            $table->integer('invitation_category_id')->index();
            $table->integer('theme_author_id')->index();
            $table->timestamps();
            $table->softDeletes(); // THIS ONE
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('themes');
    }
};
