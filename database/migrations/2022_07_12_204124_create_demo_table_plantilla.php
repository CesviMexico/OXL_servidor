<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\MetaFritterVerso\DataDemoJSON;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tabla = "plantilla_data_demo";
        Schema::create($tabla, function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->string('email', 100);
            $table->string('gender', 100);
            $table->string('ip_address', 100);
            $table->double('double', 11, 2);
            $table->date('fecha');
            $table->dateTime('fechaTime', $precision = 0);
            $table->string('action_data1')->nullable(true);
            $table->string('action_data2')->nullable(true);
            $table->string('estatus', 10)->default('ALTA');
            $table->timestamps();
        });
        DB::table($tabla)->insert(DataDemoJSON::dataDemoJSON());
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plantilla_data_demo');
    }
};
