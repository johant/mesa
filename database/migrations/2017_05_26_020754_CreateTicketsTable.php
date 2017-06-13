<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('url');
            $table->text('body');
            $table->timestamp('published_at')->nullable();
            $table->unsignedInteger('category_id');
             $table->unsignedInteger('status_id');
            $table->unsignedInteger('priority');
            $table->timestamp('closed_at')->nullable();
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('user_update');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tickets');
    }
}
