<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuthorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('authors', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('author_book', function (Blueprint $table) {
            $table->integer('author_id')->unsigned()->index();
            $table->integer('book_id')->unsigned()->index();

            $table->foreign('author_id')->references('id')->on('authors')->onDelete('cascade');
            $table->foreign('book_id')->references('id')->on('books')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('author_book', function (Blueprint $table) {
            $table->dropForeign('author_book_author_id_foreign');
            $table->dropForeign('author_book_book_id_foreign');

        });
        Schema::dropIfExists('author_book');

        Schema::dropIfExists('authors');
    }

}
