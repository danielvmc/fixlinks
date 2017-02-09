<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('links', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->text('title')->nullable();
            $table->text('description')->nullable();
            $table->string('image_link')->nullable();
            $table->string('fake_link')->nullable();
            $table->string('real_link');
            $table->integer('clicks')->default(0);
            $table->string('link_basic');
            $table->string('query_key');
            $table->string('query_value');
            $table->string('full_link');
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
        Schema::dropIfExists('links');
    }
}
