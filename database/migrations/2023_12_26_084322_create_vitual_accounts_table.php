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
        Schema::create('vitual_accounts', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement()->nullable(false);
            $table->unsignedInteger('wallet_id')->nullable(false);
            $table->string('bank', 100)->nullable(false);
            $table->string('va_number', 100)->nullable(false);
            $table->timestamps();

            $table->foreign('wallet_id')->references('id')->on('wallets')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vitual_accounts');
    }
};
