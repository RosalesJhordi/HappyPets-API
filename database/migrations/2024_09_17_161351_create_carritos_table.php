<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('carritos', function (Blueprint $table) {
            $table->id();
            $table->string("id_usuario");
            $table->string("id_producto");
            $table->string("cantidad");
            $table->string("precio_unt");
            $table->string("total");
            $table->string("estado")->nullable();
            $table->string("metodo_pago")->nullable();
            //$table->string("direccion_envio");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carritos');
    }
};
