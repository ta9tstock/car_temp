<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('device_members', function (Blueprint $table) {
            $table->id('member_id');
            $table->unsignedBigInteger('device_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('device_id')->references('device_id')->on('device')->onDelete('cascade');
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->unique(['device_id', 'user_id'], 'uk_device_user');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('device_members');
    }
};