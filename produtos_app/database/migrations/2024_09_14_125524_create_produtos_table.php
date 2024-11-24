<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    //eviando pro banco
    public function up(): void
    {
        Schema::create('produtos', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); //obrigatorio e unico
            $table->text('description')->nullable()->limit(500); //opcional e max 500 caracter
            /* metodo para lidar com valores monetarios, 8 qunt de digitos e 2 casas decimais apos a virgula */
            $table->decimal('price', 8, 2);
            $table->integer('stock')->unsigned(); //valor da coluna não pode ser negativo
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produtos');
    }
};
