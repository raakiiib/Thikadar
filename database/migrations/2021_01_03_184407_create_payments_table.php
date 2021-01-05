<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::dropIfExists('payments');
        Schema::create('payments', function (Blueprint $table) {
            

            /**
             * expense_id
             * payment_type     payment | rent
             * net_amount       100
             * paid_amount      100
             * is_all_paid      true
             * note
             * photo_path       invoice photo
             * created_at
             *
             * ahmedsadaf07@gmail.com
             * 
             */

            $table->increments('id');
            $table->integer('account_id')->index();
            $table->unsignedInteger('expense_id')->index();
            $table->string('payment_type', 50)->nullable();
            $table->double('net_amount', 10, 2)->nullable();
            $table->double('paid_amount', 10, 2)->nullable();
            $table->boolean('is_all_paid')->default(0);
            $table->string('note', 300)->nullable();
            $table->string('photo_path', 300)->nullable();
            $table->timestamps();
            $table->softDeletes();

        });

        Schema::table('payments', function($table) {
            $table->foreign('expense_id')
                ->references('id')
                ->on('expenses')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
