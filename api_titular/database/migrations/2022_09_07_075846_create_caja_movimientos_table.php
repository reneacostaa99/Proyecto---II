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
        Schema::create('caja_movimientos', function (Blueprint $table) {
            $table->id();
            $table->string('motivo')->nullable();
            $table->foreignId('caja_id')->nullable()->constrained('cajas');
            $table->string('compobante')->nullable();//nueva columna 05/06/24
            $table->decimal('monto',12,2)->default(0);
            $table->string('pago')->nullable();//nueva columna 05/06/24
            $table->integer('tipo')->default(1);
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
        Schema::dropIfExists('caja_movimientos');
    }
};
