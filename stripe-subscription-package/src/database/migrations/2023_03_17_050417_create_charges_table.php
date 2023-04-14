<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('charges', function (Blueprint $table) {
            $table->id();
            $table->string('charge_id')->nullable();
            $table->text('object')->nullable();
            $table->string('charge_customer_id')->nullable();
            $table->string('balance_transaction')->nullable();
            $table->string('plan_amount')->nullable();
            $table->string('payer_email')->nullable();
            $table->string('plan_amount_currency')->nullable();
            $table->string('charge_create')->nullable();
            $table->string('charge_currency')->nullable();
            $table->text('charge_description')->nullable();
            $table->string('charge_invoice')->nullable();
            $table->text('seller_message')->nullable();
            $table->string('payment_intent')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('paid_status')->nullable();
            $table->string('charge_country')->nullable();
            $table->string('exp_month')->nullable();
            $table->string('exp_year')->nullable();
            $table->string('funding')->nullable();
            $table->string('last4')->nullable();
            $table->string('network')->nullable();
            $table->string('type')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('charges');
    }
};
