<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMotorcycleStockTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('motorcycle_stock', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('motorcycle_id')->comment('Reference to product');
            $table->unsignedBigInteger('quantity')->comment('qauntity motorcycle');
            $table->unsignedBigInteger('operation')->comment('add (1) or remove (2)');

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('motorcycle_id')->references('id')->on('motorcycles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('motorcycle_stock');
    }
}
