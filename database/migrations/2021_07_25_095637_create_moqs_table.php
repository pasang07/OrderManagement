<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMoqsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('moqs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('product_id')->unsigned()->default(0)->index();
            $table->text('batch_no')->nullable();
            $table->text('bottle_case')->nullable();
            $table->bigInteger('moq_low')->nullable();
            $table->bigInteger('moq_high')->nullable();
            $table->float('rate')->nullable();
            $table->float('amount')->nullable();
            $table->enum('status',['active','in_active'])->default('active');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('moqs');
    }
}
