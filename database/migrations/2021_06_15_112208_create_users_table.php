<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('username')->nullable()->unique();
            $table->string('password')->nullable();
            $table->enum('role',['superadmin','admin','agent','others','demo'])->nullable();
            $table->text('phone')->nullable();
            $table->enum('gender',['male','female','others'])->nullable();
            $table->text('address')->nullable();
            $table->text('image')->nullable();
            $table->enum('status',['active','in_active'])->default('active')->nullable();
            $table->enum('is_new',['yes','no'])->default('yes')->nullable();
            $table->string('verification_code')->nullable()->unique();
            $table->string('is_verified')->default(0);
            $table->text('refer_by')->default('none');
            $table->text('created_by')->default(1);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
