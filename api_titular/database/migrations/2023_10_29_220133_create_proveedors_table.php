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
        Schema::create('proveedors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tipo_id')->nullable()->constrained('tipos');          
            $table->string('nombre')->nullable();
            $table->string('apellido')->nullable();
            $table->string('direccion')->nullable();
            $table->foreignId('distrito_id')->nullable()->constrained('distritos');
            $table->string('telefono')->nullable();
            $table->string('celular')->nullable();
            $table->string('nro_ruc')->nullable();
            $table->string('nro_ci')->nullable();
            $table->string('correo')->nullable();
            $table->foreignId('persona_id')->nullable()->constrained('personas');      
            $table->integer('estado')->default(1);
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
        Schema::dropIfExists('proveedors');
    }
};
