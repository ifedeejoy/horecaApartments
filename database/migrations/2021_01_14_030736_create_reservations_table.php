<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->uuid('reference');
            $table->foreignId('apartments_id');
            $table->timestamp('checkin');
            $table->timestamp('checkout');
            $table->integer('nights');
            $table->foreignId('rate_id');
            $table->string('status');
            $table->integer('occupants');
            $table->foreignId('guest_id');
            $table->foreignId('createdBy');
            $table->mediumText('extras');
            $table->string('source')->nullable();
            $table->foreignId('agent_id')->nullable();
            $table->foreignId('modifiedBy')->nullable();
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
        Schema::dropIfExists('reservations');
    }
}
