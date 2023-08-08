<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStateCategoryTool extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('categoryTools', function($t) {
            DB::statement("ALTER TABLE `categorytools` add column  `active` boolean null ");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('categoryTools', function($t) {
            DB::statement("ALTER TABLE `categorytools` add column  `active` boolean  null ");
        });
    }
}
