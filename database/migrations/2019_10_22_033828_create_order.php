<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->nullable(false);
            $table->string('number_of_visa', 25)->nullable(false);
            $table->string('visa_type')->nullable(false);
            $table->enum('purpose', ['tourist visa', 'business visa', 'other'])->nullable(false);
            $table->string('airport_arrival', 125)->nullable(false);
            $table->enum('process_type', ['normal', 'urgent', 'supper urgent'])->nullable(false)->default('normal');
            $table->enum('is_full_packet_service', ['yes', 'no'])->nullable(false)->default('no')->comment('Full visa services at the airport');
            $table->enum('airport_fast_track', ['yes', 'no'])->nullable(false)->default('no')->comment('one of extra services');
            $table->enum('car_pick_up', ['4 seat', '7 seat', '16 seat', '24 seat'])->nullable(true)->default(null)->comment('one of extra services');
            $table->dateTime('date_of_arrival')->nullable(false);
            $table->dateTime('date_of_departure')->nullable(false);
            $table->string('payment_type', 125)->nullable(false);
            $table->string('special_request', 5000)->nullable(true)->default(null);
            $table->float('total_money')->nullable(false)->default(0);
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
        Schema::dropIfExists('order');
    }
}
