<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
  /**
  * Run the migrations.
  *
  * @return void
  */
  public function up()
  {
    Schema::create('products', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->bigInteger('category_id')->unsigned()->nullable();
      $table->string('title_es');
      $table->string('title_en')->nullable();
      $table->string('title_pt')->nullable();
      $table->string('desc_es');
      $table->string('desc_en')->nullable();
      $table->string('desc_pt')->nullable();
      $table->string('product_code');
      $table->string('page')->nullable();
      $table->string('image_path')->nullable();
      $table->boolean('has_image')->nullable();
      $table->boolean('has_pdf')->nullable();
      $table->boolean('has_cad_2d')->nullable();
      $table->boolean('has_cad_3d')->nullable();
      $table->boolean('has_zip')->nullable();
      $table->timestamps();
    });

    Schema::table('products', function (Blueprint $table) {
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
    Schema::dropIfExists('products');
  }
}
