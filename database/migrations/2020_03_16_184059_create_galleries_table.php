<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGalleriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gallery', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('img');
            $table->text('thumbnail')->nullable();
            $table->text('position');
            $table->integer('width')->default('1920');
            $table->integer('height')->default('1080');
            $table->text('ratio');
            $table->boolean('visibility');
            $table->integer('sort');
            $table->bigInteger('portfolioId')->unsigned();
            $table->foreign('portfolioId')
                ->references('id')
                ->on('portfolios')
                ->onUpdate('cascade')
                ->onDelete('cascade');
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
        Schema::dropIfExists('galleries');
    }
}
