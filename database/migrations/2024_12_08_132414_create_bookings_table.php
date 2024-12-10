<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->bigIncrements('booking_id');
            $table->foreignId('user_id');
            $table->foreignId('room_id');
            $table->foreignId('unit_id');
            $table->date('event_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending');
            $table->boolean('is_deleted')->default(false);
            $table->timestamps();

            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');

            $table->foreign('room_id')
                  ->references('id')
                  ->on('rooms')
                  ->onDelete('cascade');

            $table->foreign('unit_id')
                  ->references('id')
                  ->on('units')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
