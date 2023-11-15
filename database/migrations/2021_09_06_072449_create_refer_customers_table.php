<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReferCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('refer_customers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('agent_id')->unsigned()->default(0)->index();
            $table->string('name');
            $table->string('email')->unique();
            $table->text('phone')->nullable();
            $table->text('address')->nullable();
            $table->enum('is_approve',['yes','no'])->default('no')->nullable();
            $table->bigInteger('approve_by')->nullable();
            $table->text('approve_date')->nullable();
            $table->foreign('agent_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->bigInteger('order')->nullable();
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
        Schema::dropIfExists('refer_customers');
    }
}
