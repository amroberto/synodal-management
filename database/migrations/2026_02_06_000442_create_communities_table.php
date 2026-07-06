use Illuminate\Support\Facades\DB;
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\UnityTypeEnum;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('communities', function (Blueprint $table) {
            $table->id();

            $table->string('corporate_name');              // Razão social
            $table->string('fantasy_name');                // Nome fantasia
            $table->string('cnpj', 14)->unique()->nullable(); // 14 dígitos sem máscara
            $table->enum('unity_type', array_column(UnityTypeEnum::cases(), 'value'))
                  ->default(UnityTypeEnum::COMMUNITY->value);

            // Endereço
            $table->string('cep', 8)->nullable();          // Apenas números: 01001000
            $table->string('street', 255)->nullable();
            $table->string('number', 20)->nullable();
            $table->string('complement', 100)->nullable();
            $table->string('neighborhood', 100)->nullable();
            $table->string('city', 100)->nullable();
            $table->char('state', 2)->nullable();          // UF: SP, RJ, etc.

            $table->foreignId('sector_id')->constrained()->onDelete('cascade');

            // Contatos
            $table->string('phone', 20)->nullable();       // Com DDD, ex: 1133334444
            $table->string('mobile', 20)->nullable();      // Celular com DDD
            $table->string('email')->nullable();
            $table->string('website')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('communities');
    }
};
