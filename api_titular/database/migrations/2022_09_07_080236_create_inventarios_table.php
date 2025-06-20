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
        Schema::create('inventarios', function (Blueprint $table) {
            $table->id();
            $table->string('motivo')->nullable();
            $table->foreignId('articulo_id')->nullable()->constrained('articulos');

            $table->decimal('compra',12,2)->default(0);
            $table->decimal('venta',12,2)->default(0);
            $table->decimal('cantidad',12,2)->default(0);
            $table->integer('tipo')->default(1);
            $table->integer('comprobante')->nullable();//nueva columna 05/06/24
            //$table->date('fecha');
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
        Schema::dropIfExists('inventarios');
    }
};
