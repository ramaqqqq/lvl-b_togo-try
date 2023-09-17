<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFamilyListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('family_lists', function (Blueprint $table) {
            $table->increments('fl_id');
            $table->unsignedBigInteger('cst_id');
            $table->string('fl_relation')->nullable()->default(null);
            $table->string('fl_name');
            $table->date('fl_dob');
            $table->timestamps();

            $table->foreign('cst_id')->references('cst_id')->on('customers');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('family_lists');
    }
}
