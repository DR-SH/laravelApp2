<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\Controllers\AuthorController;
use Illuminate\Foundation\Testing\DatabaseTransactions;

/**
 * Class AuthorTest
 * @package Tests\Unit
 */
class AuthorTest extends TestCase
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
        $controller = new AuthorController();        
        
        $books = factory(\App\Book::class, 3)->create()->pluck('id');
        $author = factory(\App\Author::class)->create();

        $controller->syncBooks($author, $books->toArray());

        $this->assertDatabaseHas('author_book', ['author_id' => $author->id, 'book_id' => $books->first()]);
        $this->assertDatabaseHas('author_book', ['author_id' => $author->id, 'book_id' => $books->nth(2)]);
        $this->assertDatabaseHas('author_book', ['author_id' => $author->id, 'book_id' => $books->nth(3)]);
        $this->assertDatabaseMissing('author_book', ['author_id' => $author->id, 'book_id' => $books->first()-1]);
        $this->assertDatabaseMissing('author_book', ['author_id' => $author->id-1, 'book_id' => $books->first()]);

        $controller->detachBooks($author);
        
        $this->assertDatabaseMissing('author_book', ['author_id' => $author->id, 'book_id' => $books->first()]);
        $this->assertDatabaseMissing('author_book', ['author_id' => $author->id, 'book_id' => $books->nth(2)]);
        $this->assertDatabaseMissing('author_book', ['author_id' => $author->id, 'book_id' => $books->nth(3)]);
    }
    
}
