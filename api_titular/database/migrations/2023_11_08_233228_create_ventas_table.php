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
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            $table->string('motivo')->nullable();
            $table->foreignId('cliente_id')->nullable()->constrained('clientes');   
            $table->integer('factura')->nullable();
            $table->integer('timbrado')->nullable();
            $table->decimal('total',12,2)->default(0);
            $table->decimal('pago',12,2)->default(0);
            $table->decimal('cambio',12,2)->default(0);
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
        Schema::dropIfExists('ventas');
    }
};
