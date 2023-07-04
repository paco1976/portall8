<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterLoansSetDefaultState extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Loans', function($t) {
            DB::statement("ALTER TABLE `Loans` alter column  `state_id` set  default 3");

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Loans', function($t) {
            DB::statement("ALTER TABLE `Loans` alter column  `state_id` set  default 3");
        });
    }
}
