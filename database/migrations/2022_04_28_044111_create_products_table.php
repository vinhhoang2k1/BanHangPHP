<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->string('name');
            $table->text('short_content');
            $table->text('description');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->double('price');
            $table->integer('quantity');
            $table->string('thumbnail')->nullable();
            $table->string('slug');
            $table->tinyInteger('selling_product')->nullable();
            $table->tinyInteger('common')->nullable();
            $table->tinyInteger('new_product')->nullable();
            $table->unsignedInteger('category_id');
            $table->timestamps();
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
