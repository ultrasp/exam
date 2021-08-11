<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InitTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->integer('eId')->nullable()->default(0);
            $table->timestamps();
            $table->index('eId'); 
        });

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->double('price');
            $table->integer('eId')->nullable()->default(0);
            $table->timestamps();
            $table->index('eId'); 
        });

        Schema::create('category_product', function (Blueprint $table) {
            $table->integer('category_id');
            $table->integer('product_id');
            $table->primary(['category_id', 'product_id']);
        });

        Schema::create('import_files', function (Blueprint $table) {
            $table->id();
            $table->string('file');
            $table->string('status');
            $table->text('error_')->nullable();
            $table->timestamps();
        });

        Schema::create('import_file_errors', function (Blueprint $table) {
            $table->id();
            $table->integer('import_file_id');
            $table->integer('indx');
            $table->text('data');
            $table->text('error_');
            $table->dateTime('parseTime');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
        Schema::dropIfExists('products');
        Schema::dropIfExists('category_product');
        Schema::dropIfExists('import_files');
        Schema::dropIfExists('import_file_errors');
    }
}
