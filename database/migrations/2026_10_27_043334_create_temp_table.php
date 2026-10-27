<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('temp', function (Blueprint $table) {
            $table->id('temp_id');
            $table->unsignedBigInteger('device_id');
            $table->decimal('in_temp', 4, 1);
            $table->decimal('out_temp', 4, 1)->nullable();
            $table->decimal('humidity', 4, 1)->nullable();
            $table->integer('solar')->nullable();
            $table->timestamp('get_time')->nullable();
            $table->timestamp('send_time')->nullable();
            $table->timestamp('created_time')->useCurrent();

            $table->foreign('device_id')->references('device_id')->on('device')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('temp');
    }
};