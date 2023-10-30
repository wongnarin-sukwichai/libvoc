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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->integer('ref_id')->comment('อ้างอิงโพสต์');
            $table->string('name');
            $table->string('surname');
            $table->integer('dep');
            $table->string('dep_title');
            $table->string('detail')->nullable();
            $table->integer('forward')->nullable();
            $table->string('forward_title');
            $table->integer('stat')->comment('1=ส่งต่อกลุ่มงาน,2=ดำเินการเสร็จสิ้น');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
