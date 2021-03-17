<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateToolSourceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tool_source', function (Blueprint $table) {
            $table->unsignedBigInteger('source_id');
            $table->unsignedBigInteger('tools_id');

            $table->foreign('source_id')->references('id')->on('source')
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
        Schema::dropIfExists('tool_source');
    }
}
