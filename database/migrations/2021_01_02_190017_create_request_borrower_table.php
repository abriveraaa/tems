<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestBorrowerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_borrower', function (Blueprint $table) {
            $table->unsignedBigInteger('borrower_id');
            $table->unsignedBigInteger('requests_id');

            $table->foreign('requests_id')->references('id')->on('requests')
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
        Schema::dropIfExists('request_borrower');
    }
}
