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
        //
        Schema::table('produtos', function(Blueprint $table){
            $table->dateTime('data_de_fabricação');
            $table->dateTime('data_de_vencimento');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::table('produtos', function(Blueprint $table){
            $table->dropColumn('data_de_fabricação');
            $table->dropColumn('data_de_vencimento');
        });
    }
};
