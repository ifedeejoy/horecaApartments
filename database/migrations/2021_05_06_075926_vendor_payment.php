<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class VendorPayment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendor_payments', function (Blueprint $table) {
            $table->id('id');
            $table->foreignId('apartments_id');
            $table->foreignId('maintenance_id');
            $table->foreignId('vendor_id');
            $table->decimal('cost', 10, 2);
            $table->text('cost_breakdown')->nullable();
            $table->decimal('paid', 10, 2)->nullable();
            $table->decimal('balance', 10, 2)->nullable();
            $table->string('payment_method')->nullable();
            $table->softDeletes();
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
        //
    }
}
