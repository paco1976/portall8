<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIconToCategoriaTipo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('categoria_tipo', function (Blueprint $table) {
            $table->string('icon', '400')->nullable()->default('img\slides\slide-prueba2.jpg')->after('name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('categoria_tipo', function (Blueprint $table) {
            $table->dropColumn('icon');
        });
    }
}
