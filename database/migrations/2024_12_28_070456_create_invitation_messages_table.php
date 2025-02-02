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
        Schema::create('invitation_messages', function (Blueprint $table) {
            $table->id();
            $table->string('sender_name',30);
            $table->string('sender_messages',70);
            $table->boolean('attendance_status')->default(false);
            $table->integer('number_of_attendance')->unsigned()->default(0);
            $table->integer('invitation_id')->index();
            $table->timestamps();
            $table->softDeletes(); // THIS ONE
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invitation_messages');
    }
};
