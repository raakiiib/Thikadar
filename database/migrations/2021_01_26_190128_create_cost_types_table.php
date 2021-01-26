<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCostTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cost_types', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('account_id')->index();
            $table->string('name', 50)->nullable();
            $table->string('note', 300)->nullable();
            $table->string('photo_path', 300)->nullable();
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
        Schema::dropIfExists('cost_types');
    }
}
