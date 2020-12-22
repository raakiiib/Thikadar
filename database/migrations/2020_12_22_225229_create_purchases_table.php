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
            $table->string('number', 50)->nullable();
            $table->double('quantity', 8, 2);        
            $table->double('unitprice', 8, 2);       
            $table->double('netamount', 8, 2);       
            $table->double('paid', 8, 2);            
            $table->double('due', 8, 2);
            $table->boolean('ispaid');
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
