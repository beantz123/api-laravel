<?php

use App\Models\Produtos;
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
        Schema::table('detalhes', function(Blueprint $table){
            $table->unsignedInteger('products_id');

            $table->foreign('products_id')->references('id')->on('produtos');
            $table->unique('products_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('detalhes', function(Blueprint $table){
           
            $table->dropForeign(['products_id']);
        });

        Schema::dropIfExists('detalhes');
    }
};
