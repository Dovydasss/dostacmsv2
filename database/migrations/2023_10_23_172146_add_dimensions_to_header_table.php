<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('header', function (Blueprint $table) {
            $table->unsignedInteger('width')->default(100);
            $table->unsignedInteger('height')->default(30);
        });
    }

    public function down()
    {
        Schema::table('header', function (Blueprint $table) {
            $table->dropColumn(['width', 'height']);
        });
    }
};
