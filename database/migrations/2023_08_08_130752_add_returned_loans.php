<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReturnedLoans extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::table('loans', function($t) {
        //     DB::statement("ALTER TABLE `loans` add column  `returned` boolean default 0 ");
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::table('loans', function($t) {
        //     DB::statement("ALTER TABLE `loans` add column  `returned` boolean default 0 ");
        // });
    }
} 
