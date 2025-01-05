<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('unit_id');
            $table->string('user_name');
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('role', ['admin', 'user'])->default('user');
            $table->string('api_token');
            $table->boolean('is_deleted')->default(false);
            $table->timestamps();

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
        Schema::dropIfExists('users');
    }
};
