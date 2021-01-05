<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expenses', function (Blueprint $table) {

            /**
             * account_id
             * expense_type     products (1) | services(2) | daily_expenses(3)
             * vendor_id
             * product_id
             * invoice_number
             * quantity
             * size
             * unit_price
             * net_amount
             * paid_amount
             * due_amount
             * is_all_paid
             * note
             * photo_path
             * 
             */
            
            $table->increments('id');
            $table->integer('account_id')->index();  
            $table->integer('expense_type')->index();
            $table->integer('vendor_id')->nullable();
            $table->integer('product_id')->nullable();
            $table->string('invoice_number', 20)->nullable()->uniqid();
            $table->double('quantity', 10, 2)->nullable();
            $table->double('size', 10, 2)->nullable();
            $table->double('unit_price', 10, 2)->nullable();
            $table->double('net_amount', 10, 2)->nullable();
            $table->double('paid_amount', 10, 2)->nullable();
            $table->double('due_amount', 10, 2)->nullable();
            $table->boolean('is_all_paid')->default(0);
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
        Schema::dropIfExists('expenses');
    }
}
