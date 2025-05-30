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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->nullable();
            $table->integer('uid');
            $table->string('pic')->nullable();
            $table->string('name');
            $table->string('surname');
            $table->integer('dep');
            $table->string('email')->nullable();
            $table->string('password')->nullable();
            $table->string('created_by');
            $table->integer('system')->nullable()->comment('เช็ค admin ระบบ voc');
            $table->rememberToken();
            $table->timestamps();
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
