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
        Schema::create('contract_addresses', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignUuid('coin_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignUuid('platform_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('contract_address')
                ->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contract_addresses');
    }
};
