<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVersionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('versions', function (Blueprint $table) {
            $table->unsignedBigInteger('version_id', true);
            $table->unsignedBigInteger('application_id');
            $table->foreign('application_id')->references('application_id')->on('applications');
            $table->string('version')->index();
            $table->string('app_file')->nullable();
            $table->json('images')->nullable();
            $table->text('change_log')->nullable();
            $table->enum('status', ['pending', 'in_progress', 'approved', 'rejected', 'released', 'banned'])->default('pending');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('versions');
    }
}
