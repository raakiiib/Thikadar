<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_services', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('account_id')->index();  
                $table->unsignedInteger('service_id');  
                $table->unsignedInteger('supplier_id');  
                $table->string('invoice_number', 20)->nullable()->uniqid();
                $table->double('quantity', 10, 2)->nullable();
                $table->string('size', '10')->nullable();
                $table->double('unitprice', 10, 2)->nullable();
                $table->double('net_amount', 10, 2)->nullable();
                $table->double('paid_amount', 10, 2)->nullable();
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
        Schema::dropIfExists('purchase_services');
    }
}
