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
        Schema::table('invitation_contents', function (Blueprint $table) {
            $table->string('content_category')->default('to_be_published')->index(); //to_be_published or preview
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invitation_contents', function (Blueprint $table) {
            $table->dropColumn('content_category');
        });
    }
};
