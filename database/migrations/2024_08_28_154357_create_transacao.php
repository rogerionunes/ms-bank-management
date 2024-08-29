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
        Schema::create('transacao', function (Blueprint $table) {
            $table->id('id_transacao');
            $table->unsignedBigInteger('id_conta');
            $table->enum('forma_pagamento', ['P', 'C', 'D']);
            $table->float('taxa');
            $table->float('valor');
            $table->timestamps();

            $table->foreign('id_conta')->references('id_conta')->on('conta');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transacao');
    }
};
