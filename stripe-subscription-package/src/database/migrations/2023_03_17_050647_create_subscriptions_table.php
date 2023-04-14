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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->text('booking_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->string('customer_id')->nullable();
            $table->string('subscription_id')->nullable();
            $table->string('plan_id')->nullable();
            $table->string('plan_interval')->nullable();
            $table->string('currency')->nullable();
            $table->string('plan_period_start')->nullable();
            $table->string('plan_period_end')->nullable();
            $table->float('amount_paid')->nullable();
            $table->string('invoice_url')->nullable();
            $table->string('payment_status')->nullable();
            $table->string('subscription_status')->nullable();
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
        Schema::dropIfExists('subscriptions');
    }
};
