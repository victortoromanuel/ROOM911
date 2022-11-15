<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

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

        DB::table('admin_room_911s')->insert(
            array(
                'id_admin_room_911' => 1,
                'username' => 'admin',
                'password' => 'admin',
                'created_at' => '2022-11-14 19:35:18',
                'updated_at' => '2022-11-14 19:35:18',
                'id_employee' => 1,
            )
        );
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
