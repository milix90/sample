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
            $table->unsignedBigInteger('user_id', true);
            $table->string('name');
            $table->string('email')->unique()->index();
            $table->string('mobile')->unique()->index();
            $table->string('phone')->nullable()->comment('office or other numbers');
            $table->text('address')->nullable()->comment('office address for companies and teams');
            $table->string('password');
            $table->enum('client_type', ['company', 'team', 'individual'])->default('individual');
            $table->string('username')->index();
            $table->boolean('active')->default(true);
            $table->boolean('verify')->default(false);
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
