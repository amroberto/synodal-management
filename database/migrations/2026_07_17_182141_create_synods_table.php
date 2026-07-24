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
        Schema::create('synods', function (Blueprint $table) {
            $table->id();
            $table->string('corporate_name');
            $table->string('fantasy_name');
            $table->string('cnpj', 14)->unique()->nullable();

            // Endereço
            $table->string('cep', 8)->nullable();
            $table->string('street', 255)->nullable();
            $table->string('number', 20)->nullable();
            $table->string('complement', 100)->nullable();
            $table->string('neighborhood', 100)->nullable();
            $table->string('city',100)->nullable();
            $table->string('state', 2)->nullable();

            // Contatos
            $table->string('phone', 20)->nullable();
            $table->string('mobile', 20)->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->text('logo')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('synods');
    }
};
