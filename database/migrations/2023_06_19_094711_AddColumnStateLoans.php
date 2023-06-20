<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnStateLoans extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Loans', function($t) {
            DB::statement("ALTER TABLE `Loans` add COLUMN `state_id` INT(11) UNSIGNED  NULL");
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
            DB::statement("ALTER TABLE `Loans` add COLUMN `state_id` INT(11) UNSIGNED  NULL");
        });
    }
}
