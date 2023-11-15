<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNavsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('navs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('parent_id')->default(0);
            $table->text('title')->nullable();
            $table->text('slug')->nullable();
            $table->text('url')->nullable();
            $table->text('image')->nullable();
            $table->text('type')->nullable();
            $table->bigInteger('type_id')->default(0);
            $table->enum('target',['_blank','_self'])->default('_self')->nullable();
            $table->enum('show_image',['yes','no'])->default('yes')->nullable();
            $table->integer('order')->nullable();
            $table->enum('status',['active','in_active'])->default('active')->nullable();
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
        Schema::dropIfExists('navs');
    }
}
