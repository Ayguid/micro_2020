<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attributes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('category_id')->unsigned()->nullable();
            $table->string('name_es');
            $table->string('name_en');
            $table->string('name_pt');
            $table->boolean('filterable')->nullable();
            $table->string('type')->nullable();
            $table->timestamps();
        });


        Schema::table('attributes', function (Blueprint $table) {
            $table->foreign('category_id')->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attributes');
    }
}
