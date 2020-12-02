<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

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
            $table->bigInteger('category_id')->unsigned();
            $table->string('code');
            $table->unsignedInteger('start_bid_price');
            $table->unsignedInteger('min_bid_price');
            $table->unsignedInteger('watched_count');
            $table->timestamp('start_at');

            $table->unsignedTinyInteger('status')
                ->default(0)
                ->comment('0 => not approved, 1 => active, 2 => pending, 3 => finished');

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });



        Schema::create('product_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('product_id')->unsigned();
            $table->string('locale')->index();
            $table->string('name');
            $table->longText('description');

            $table->unique(['product_id', 'locale']);
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });


        Schema::create('product_gallery', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('product_id')->unsigned();
            $table->string('photo');

            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('product_gallery');
        Schema::drop('product_translations');
        Schema::drop('products');
    }
}
