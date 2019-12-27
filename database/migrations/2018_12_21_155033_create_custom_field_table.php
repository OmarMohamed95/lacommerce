<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomFieldTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('custom_fields', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('type');
            $table->boolean('show_in_filter');
            $table->timestamps();
        });

        Schema::create('custom_field_products', function (Blueprint $table) {
            $table->integer('product_id');
            $table->integer('custom_field_id');
            $table->string('value');
        });

        Schema::create('custom_field_categories', function (Blueprint $table) {
            $table->integer('category_id');
            $table->integer('custom_field_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('custom_fields');
        Schema::dropIfExists('custom_field_products');
        Schema::dropIfExists('custom_field_categories');
    }
}
