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
        Schema::create('departments', function (Blueprint $table) {
            $table->id('id_department');
            $table->string('department_name');
            #$table->timestamps();
        });

        // Insert some stuff
        DB::table('departments')->insert(
            array(
                'id_department' => 1,
                'department_name' => 'Department1'
            )
        );

        DB::table('departments')->insert(
            array(
                'id_department' => 2,
                'department_name' => 'Department2'
            )
        );

        DB::table('departments')->insert(
            array(
                'id_department' => 3,
                'department_name' => 'Department3'
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
        Schema::dropIfExists('departments');
    }
};
