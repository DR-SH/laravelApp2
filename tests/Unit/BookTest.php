<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\Controllers\BookController;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BookTest extends TestCase
{
    use DatabaseTransactions;

    // protected



    /**
     * A test of syncBooks and DetachBooks methods.
     *
     * @return void
     */
    public function testSyncAndDetachBooks()
    {
        $controller = new BookController();

        $book = factory(\App\Book::class)->create();
        $authors = factory(\App\Author::class, 2)->create()->pluck('id');

        $controller->syncAuthors($book, $authors->toArray());

        $this->assertDatabaseHas('author_book', ['author_id' => $authors->first(), 'book_id' => $book->id]);
        $this->assertDatabaseHas('author_book', ['author_id' => $authors->nth(2), 'book_id' => $book->id]);
        $this->assertDatabaseMissing('author_book', ['author_id' => $authors->first(), 'book_id' => $book->id-1]);
        $this->assertDatabaseMissing('author_book', ['author_id' => $authors->first()-1, 'book_id' => $book->id]);
        
    }
}
