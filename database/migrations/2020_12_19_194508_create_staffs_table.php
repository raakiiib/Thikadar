<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaffsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staffs', function (Blueprint $table) {
            $table->id();
            $table->integer('account_id')->index();
            $table->string('name', 100);
            $table->string('date_of_birth', 20)->nullable();
            $table->string('national_id', 50)->nullable();
            $table->string('email', 50)->unique()->nullable();
            $table->string('phone', 50)->unique();
            $table->string('address', 150)->nullable();
            $table->string('village', 50)->nullable();
            $table->string('district', 50)->nullable();
            $table->string('country', 2)->nullable();
            $table->string('postal_code', 25)->nullable();
            $table->string('salary', 10)->nullable();
            $table->string('photo_path', 100)->nullable();
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
        Schema::dropIfExists('staffs');
    }
}
