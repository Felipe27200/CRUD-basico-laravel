<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpleadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Crea la tabla
        Schema::create('empleados', function (Blueprint $table) {
            // Estas son las columnas

            /* Por defecto el id se define como autoincremental */
            $table->id();
            /* el método de $table string() define el tipo
            de dato en la tabla y el nombre que este tendrá.
            En la documentación de laravel se puede buscar
            que otros tipos de datos es posible definir para
            el campo */
            $table->string('Nombre');
            $table->string('ApellidoPaterno');
            $table->string('ApellidoMaterno');
            $table->string('Correo');
            $table->string('Foto');
            
            /* Aquí van a aparecer la fecha del registro nuevo
            y el antiguo */
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
        Schema::dropIfExists('empleados');
    }
}
