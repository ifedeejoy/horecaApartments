<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservation_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reservation_id');
            $table->string('payment_status');
            $table->string('payment_method')->nullable();
            $table->boolean('service_charge')->nullable();
            $table->mediumText('discount_reason')->nullable();
            $table->decimal('discount_amount', 10, 2)->nullable();
            $table->decimal('total', 10, 2)->nullable();
            $table->decimal('paid', 10, 2)->nullable();
            $table->decimal('balance', 10, 2)->nullable();
            $table->decimal('refund', 10, 2)->nullable();
            $table->foreignId('guest_id');
            $table->foreignId('createdBy');
            $table->foreignId('modifiedBy');
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
        Schema::dropIfExists('reservation_payments');
    }
}
