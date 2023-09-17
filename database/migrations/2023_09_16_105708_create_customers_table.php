<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
        $table->id('cst_id');
        $table->unsignedBigInteger('nationality_id');
        $table->string('cst_name');
        $table->date('cst_dob');
        $table->string('cst_phone_num')->default(''); 
        $table->string('cst_email')->nullable();    
        $table->timestamps();

        $table->foreign('nationality_id')->references('nationality_id')->on('nationalities');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
}
