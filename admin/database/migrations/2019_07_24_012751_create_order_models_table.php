<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Eloquent\SoftDeletes;

class CreateOrderModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    
    public function up()
    {
        Schema::create('order_models', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('employeeID');
            $table->string('ticketID');
            $table->unsignedInteger('groupID');
            $table->string('roleName',500);
            $table->string('approval');
            $table->string('remarks', 5000);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('employeeID')->references('id')->on('employee_datas')->onDelete('cascade');
            $table->foreign('groupID')->references('id')->on('groups')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_models');
    }
}
