<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBorrowerCollegeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('borrower_college', function (Blueprint $table) {
            $table->unsignedBigInteger('college_id');
            $table->unsignedBigInteger('borrower_id');

            $table->foreign('college_id')->references('id')->on('colleges')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('borrower_id')->references('id')->on('borrowers')
                ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('borrower_college');
    }
}
