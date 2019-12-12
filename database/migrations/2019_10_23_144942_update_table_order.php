<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTableOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order', function (Blueprint $table) {
		    $table->enum('status_order', ['pending', 'success'])->nullable(false)->default('pending')->after('purpose');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('order', 'status_order'))
        {
            Schema::table('order', function (Blueprint $table)
            {
                $table->dropColumn('status_order');
            });
        }
    }
}
