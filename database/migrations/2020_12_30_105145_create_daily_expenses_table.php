<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDailyExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::dropIfExists('daily_expenses');
        Schema::create('daily_expenses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('account_id')->index();  
            $table->string('invoice_number', 20)->nullable()->uniqid();
            $table->string('name', 150)->nullable();
            $table->string('note', 300)->nullable();
            $table->double('net_amount', 10, 2)->nullable();
            $table->double('paid_amount', 10, 2)->nullable()->default(0);
            $table->double('due_amount', 10, 2)->nullable();
            $table->boolean('is_all_paid')->default(0);
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
        Schema::dropIfExists('daily_expenses');
    }
}
