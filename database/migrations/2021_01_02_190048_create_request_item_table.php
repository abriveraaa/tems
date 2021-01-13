<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_item', function (Blueprint $table) {
            $table->unsignedBigInteger('tool_name_id');
            $table->unsignedBigInteger('requests_id');

            $table->foreign('requests_id')->references('id')->on('requests')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('tool_name_id')->references('id')->on('tool_names')
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
        Schema::dropIfExists('request_item');
    }
}
