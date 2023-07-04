<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnActiveTools extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Tools', function($t) {
            DB::statement("ALTER TABLE `tools` add column  `active` boolean null");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Tools', function($t) {
            DB::statement("ALTER TABLE `tools` add column  `active` boolean null");
        });
    }
}
