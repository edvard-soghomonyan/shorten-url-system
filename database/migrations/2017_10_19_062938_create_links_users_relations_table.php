<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLinksUsersRelationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('links_users_relations', function (Blueprint $table) {
            $table->bigInteger('link_id')->unsigned();
            $table->integer('user_id')->unsigned();

            $table->foreign('link_id')->references('id')->on('links');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('links_users_relations');
    }
}
