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
        Schema::create('carnes', function (Blueprint $table) {
            $table->id();
            $table->decimal('valor_total', 8, 2);
            $table->integer('qtd_parcelas');
            $table->date('data_primeiro_vencimento');
            $table->string('periodicidade'); // mensal ou semanal
            $table->decimal('valor_entrada', 8, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carnes');
    }
};
