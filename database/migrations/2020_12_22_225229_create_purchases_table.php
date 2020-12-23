<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('purchases');
        Schema::create('purchases', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('account_id')->index();  
            $table->unsignedInteger('material_id');  
            $table->unsignedInteger('supplier_id');  
            $table->string('invoice_number', 50)->nullable()->uniqid();
            $table->double('quantity', 8, 2)->nullable();
            $table->double('unitprice', 8, 2)->nullable();
            $table->double('net_amount', 8, 2)->nullable();
            $table->double('paid_amount', 8, 2)->nullable();            
            $table->double('due_amount', 8, 2)->nullable();
            $table->boolean('is_all_paid')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::table('purchases', function($table) {
            $table->foreign('material_id')->references('id')->on('raw_materials');
            $table->foreign('supplier_id')->references('id')->on('suppliers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchases');
    }
}
