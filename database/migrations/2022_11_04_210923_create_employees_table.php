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
        Schema::create('employees', function (Blueprint $table) {
            $table->id('id_employee');
            $table->integer('id_number')->unique();
            $table->string('firstname');
            $table->string('lastname');
            $table->boolean('access');
            $table->timestamps();

            $table->foreignId('id_department')->references('id_department')->on('departments');
        });

        DB::table('employees')->insert(
            array(
                'id_employee' => 1,
                'id_number' => 1000000,
                'firstname' => 'Victor Manuel',
                'lastname' => 'Toro Cedeño',
                'access' => 1,
                'created_at' => '2022-11-14 19:35:18',
                'updated_at' => '2022-11-14 19:35:18',
                'id_department' => 1
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
        Schema::dropIfExists('employees');
    }
};
