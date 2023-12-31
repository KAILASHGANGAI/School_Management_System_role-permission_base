<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staff', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('address');
            $table->string('contact')->nullable();
            $table->string('email')->unique();
            $table->string('password')->default('123123');
            $table->string('staff_category')->nullable();
            $table->string('gender')->nullable();
            $table->string('salary')->nullable();
            $table->string('bloodgroup')->nullable();
            $table->string('dob')->nullable();
            $table->string('experience')->nullable();
            $table->string('education')->nullable();
            $table->string('images')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('staff');
    }
};
