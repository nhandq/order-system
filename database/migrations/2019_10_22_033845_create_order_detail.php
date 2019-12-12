<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_detail', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id')->nullable(false);
            $table->string('passport_full_name', 50)->nullable(false);
            $table->enum('passport_gender', ['male', 'female'])->nullable(false);
            $table->date('passport_date_of_birth')->nullable(false);
            $table->string('nationality')->nullable(false);
            $table->string('passport_number', 25)->nullable(false);
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
        Schema::dropIfExists('order_detail');
    }
}
