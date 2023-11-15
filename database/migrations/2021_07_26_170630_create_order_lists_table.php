<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_lists', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('customer_id')->unsigned()->default(0)->index();
            $table->bigInteger('product_id')->unsigned()->default(0)->index();
            $table->text('order_no')->nullable();
            $table->bigInteger('qty')->nullable();
            $table->float('rate')->nullable();
            $table->float('amount')->nullable();
            $table->text('remarks')->nullable();
            $table->enum('is_cancelbycustomer',['yes','no'])->default('no');
            $table->float('shipping_cost')->nullable();
            $table->bigInteger('discount_percent')->nullable();
            $table->float('discount_cost')->nullable();
            $table->bigInteger('vat_percent')->nullable();
            $table->float('vat_cost')->nullable();
            $table->float('net_amount')->nullable();
            $table->date('estimate_delivery_date')->nullable();
            $table->enum('is_confirm',['yes','no'])->default('no');
            $table->enum('is_approve',['yes','no'])->default('no');
            $table->enum('is_reject',['yes','no'])->default('no');
            $table->enum('is_cancelled',['yes','no'])->default('no');
            $table->enum('order_status',['is_request','is_review','is_confirmed','is_cancel','is_reject','is_approved'])->default('is_request');
            $table->float('org_qty')->nullable();
            $table->float('org_amount')->nullable();
            $table->text('managed_by')->nullable();
            $table->text('managed_date')->nullable();
            $table->longText('managed_reason')->nullable();
            $table->enum('reject_notification',['sent','not_sent'])->default('not_sent');
            $table->enum('is_reviewed',['yes','no'])->default('no');
            $table->enum('status',['active','in_active'])->default('active');
            $table->bigInteger('order')->nullable();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('customer_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('order_lists');
    }
}
