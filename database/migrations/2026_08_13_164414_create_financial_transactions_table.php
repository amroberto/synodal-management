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
        Schema::create('financial_transactions', function (Blueprint $table) {
            $table->id();

            // Conta financeira onde ocorreu a movimentação
            $table->foreignId('financial_account_id')
                ->constrained('financial_accounts')
                ->restrictOnDelete();

            // Data efetiva da movimentação
            $table->date('transaction_date');

            // Entrada ou saída
            $table->string('type');

            // Descrição do lançamento
            $table->string('description');

            // Valor da movimentação
            $table->decimal('amount', 15, 2);

            // Plano de contas
            $table->foreignId('account_plan_id')
                ->nullable()
                ->constrained('account_plans')
                ->nullOnDelete();

            // Centro de custos
            $table->foreignId('cost_center_id')
                ->nullable()
                ->constrained('cost_centers')
                ->nullOnDelete();

            // Plano de oferta, quando o lançamento estiver
            // relacionado a uma oferta específica
            $table->foreignId('offer_plan_id')
                ->nullable()
                ->constrained('offer_plans')
                ->nullOnDelete();

            $table->text('notes')->nullable();

            $table->timestamps();

            $table->index('transaction_date');
            $table->index('type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('financial_transactions');
    }
};
