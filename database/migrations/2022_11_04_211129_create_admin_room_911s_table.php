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
        Schema::create('admin_room_911s', function (Blueprint $table) {
            $table->id('id_admin_room_911');
            $table->string('username')->unique();
            $table->string('password')->unique();
            $table->timestamps();

            $table->foreignId('id_employee')->references('id_employee')->on('employees');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_room_911s');
    }
};
