<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('subscription_plan_id');
            $table->string('invoice_number');
            $table->string('payment_method')->nullable();
            $table
                ->float('total_amount', 10, 2)
                ->default(0)
                ->nullable();
            $table
                ->float('paid_amount', 10, 2)
                ->default(0)
                ->nullable();
            $table->text('bank_trans_id')->nullable();
            $table->text('gateway_val_id')->nullable();
            $table->text('gateway_status')->nullable();
            $table->string('payment_status')->nullable();
            $table->string('status')->nullable();
            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_payments');
    }
};
