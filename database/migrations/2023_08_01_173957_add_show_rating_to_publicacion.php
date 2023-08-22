<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddShowRatingToPublicacion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('publicacion', function (Blueprint $table) {
            $table->boolean('show_rating')->default(true);
        });
    }

    public function down()
    {
        Schema::table('publicacion', function (Blueprint $table) {
            $table->dropColumn('show_rating');
        });
    }
}
