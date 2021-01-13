<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateToolReportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tool_report', function (Blueprint $table) {
            $table->unsignedBigInteger('borrower_id');
            $table->unsignedBigInteger('tools_id');

            $table->foreign('borrower_id')->references('id')->on('borrowers')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('tools_id')->references('id')->on('tools')
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
        Schema::dropIfExists('tool_report');
    }
}
