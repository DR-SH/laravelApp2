<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookTest extends TestCase
{
    /**
     * User visits '/books' page
     *
     * @return void
     */
    public function testBooksIndexPage()
    {
        $user = factory(User::class)->create();
        $response = $this->actingAs($user)->get('/books');
        $response->assertStatus(200);
    }

    /**
     * User visits '/books/create' page
     *
     * @return void
     */
    public function testBooksCreatePage()
    {
        $user = factory(User::class)->create();
        $response = $this->actingAs($user)->get('/books/create');
        $response->assertStatus(200);
    }

    /**
     * User creates new book with proper data
     *
     * @return void
     */
    public function testAuthorsStorePage()
    {
        $user = factory(User::class)->create();
        $author = factory(\App\Author::class)->create();
        $input = ['title' => 'New Book Title',
                  'about' => 'New Book Description',
                  'authors' => [$author->id]];
        $response = $this->actingAs($user)->post('/books', $input);

        $this->assertDatabaseHas('books', ['title' => 'New Book Title']);

        $response->assertStatus(302);
        $response->assertRedirect('/books');
        $response->assertSessionHasNoErrors();
    }

    /**
     * User creates new book with wrong name data
     *
     * @return void
     */
    public function testAuthorsStorePageWithNameError()
    {
        $user = factory(User::class)->create();
        $author = factory(\App\Author::class)->create();

        $inputTitleError = ['title' => 'New!','about' => 'qqqq', 'authors' => $author->id];
        $response1 = $this->actingAs($user)->post('/books', $inputTitleError);
        $response1->assertSessionHasErrors();
        $response1->assertStatus(302);

        $inputAboutError = ['title' => 'NewBook','about' => 'qq', 'authors' => $author->id];
        $response2 = $this->actingAs($user)->post('/books', $inputAboutError);
        $response2->assertSessionHasErrors();
        $response2->assertStatus(302);

        $inputAuthorsError = ['title' => 'NewBook','about' => 'qq'];
        $response3 = $this->actingAs($user)->post('/books', $inputAuthorsError);
        $response3->assertSessionHasErrors();
        $response3->assertStatus(302);
    }

    /**
     * User creates new book with wrong author
     *
     * @return void
     */
    public function testAuthorsStorePageWithBooksError()
    {
        $user = factory(User::class)->create();
        $input = ['title' => 'NewBook','about' => 'NewBookAbout', 'authors' => 0];
        $response = $this->actingAs($user)->post('/books', $input);
        $response->assertStatus(500);
    }
    
    /**
     * User visits edit page and updates the book
     *
     * @return void
     */
    public function testAuthorsEditAndUpdatePage()
    {
        $book = factory(\App\Book::class)->create();
        $author = factory(\App\Author::class)->create();
        $user = factory(User::class)->create();

        $responseEdit = $this->actingAs($user)->get('/books/'.$book->id.'/edit');
        $responseEdit->assertStatus(200);

        $responseUpdate = $this->actingAs($user)->patch('/books/'.$book->id, ['title'   => 'Lorem Ipsum Test Update',
                                                                              'about'   => 'Lorem Ipsum Description',
                                                                              'authors' =>  [$author->id]]);
        $this->assertDatabaseHas('books', ['title' => 'Lorem Ipsum Test Update']);
        $responseUpdate->assertStatus(302);
        $responseUpdate->assertRedirect('/books');
        $responseUpdate->assertSessionHasNoErrors();

        $responseUpdateError = $this->actingAs($user)->patch('/books/'.$book->id, ['title' => '']);
        $responseUpdateError->assertStatus(302);
        $responseUpdateError->assertSessionHasErrors();

        $this->assertDatabaseHas('books', ['title' => 'Lorem Ipsum Test Update']);
    }


    /**
     * User deletes the book
     *
     * @return void
     */
    public function testAuthorsDestroyPage()
    {
        $book = factory(\App\Book::class)->create();
        $user = factory(User::class)->create();

        $responseDestroy = $this->actingAs($user)->delete('/books/'.$book->id);
        $responseDestroy->assertStatus(302);
        $responseDestroy->assertSessionHasNoErrors();
        $this->assertDatabaseMissing('books', ['id' => $book->id]);
    }
}
