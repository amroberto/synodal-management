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
        Schema::create('offer_plans', function (Blueprint $table) {
            $table->id();
            $table->date('offer_date');
            $table->string('liturgical_date');
            $table->string('offer_instance');
            $table->foreignId('offer_destination_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            $table->foreignId('account_plan_id')
                ->constrained()
                ->restrictOnDelete();
            $table->boolean('active')->default(true);
            $table->foreignId('cost_center_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            $table->timestamps();

            $table->unique(['offer_date', 'offer_instance']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offer_plans');
    }
};
