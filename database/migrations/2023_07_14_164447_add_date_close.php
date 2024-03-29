<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDateClose extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Loans', function($t) {
            DB::statement("ALTER TABLE `loans` add column  `dateClose` datetime null");
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
            DB::statement("ALTER TABLE `loans` add column  `dateClose` datetime null");
        });
    }
}
