<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class GuestBill extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guest_bill', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('reservation_id');
            $table->foreignId('guest_id');
            $table->string('service');
            $table->mediumText('description')->nullable();
            $table->decimal('price', 10,2);
            $table->string('status')->default('unpaid');
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
