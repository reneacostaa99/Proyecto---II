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
        Schema::create('compras', function (Blueprint $table) {
            $table->id();
            $table->string('motivo')->nullable();
            $table->foreignId('proveedor_id')->nullable()->constrained('proveedors'); 
            $table->integer('factura')->nullable();
            $table->string('timbrado')->nullable();
            $table->decimal('total',12,2)->default(0);
            $table->date('fecha')->nullable();
            $table->string('tipo_compra')->nullable();
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
        Schema::dropIfExists('compras');
    }
};
