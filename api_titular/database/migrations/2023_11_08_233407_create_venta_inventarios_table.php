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
        Schema::create('venta_inventarios', function (Blueprint $table) {
            $table->id();

            $table->foreignId('inventario_id')->nullable()->constrained('inventarios');
            $table->foreignId('venta_id')->nullable()->constrained('ventas');

            $table->decimal('precio',12,2)->default(0);

            $table->decimal('cantidad',12,2)->default(0);

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
        Schema::dropIfExists('venta_inventarios');
    }
};
