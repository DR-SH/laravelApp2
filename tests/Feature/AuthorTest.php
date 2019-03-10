<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthorTest extends TestCase
{
    /**
     * User visits '/authors' page
     *
     * @return void
     */
    public function testAuthorsIndexPage()
    {
        $user = factory(User::class)->create();
        $response = $this->actingAs($user)->get('/authors');
        $response->assertStatus(200);
    }

    /**
     * User visits '/authors/create' page
     *
     * @return void
     */
    public function testAuthorsCreatePage()
    {
        $user = factory(User::class)->create();
        $response = $this->actingAs($user)->get('/authors/create');
        $response->assertStatus(200);
    }

    /**
     * User creates new author with proper data
     *
     * @return void
     */
    public function testAuthorsStorePage()
    {
        $user = factory(User::class)->create();
        $book = factory(\App\Book::class)->create();
        $input = ['name' => 'Lorem ipsum Test', 'books' => [$book->id]];
        $response = $this->actingAs($user)->post('/authors', $input);

        $this->assertDatabaseHas('authors', ['name' => 'Lorem ipsum Test']);

        $response->assertStatus(302);
        $response->assertRedirect('/authors');
        $response->assertSessionHasNoErrors();
    }
    
    /**
     * User creates new author with wrong name data
     *
     * @return void
     */
    public function testAuthorsStorePageWithNameError()
    {
        $user = factory(User::class)->create();
        $input = ['name' => ''];
        $response = $this->actingAs($user)->post('/authors', $input);
        $response->assertSessionHasErrors();
        $response->assertStatus(302);
    }
    
    /**
     * User creates new author with wrong book id
     *
     * @return void
     */
    public function testAuthorsStorePageWithBooksError()
    {
        $user = factory(User::class)->create();
        $input = ['name' => 'Lorem ipsum test', 'books' => 0];
        $response = $this->actingAs($user)->post('/authors', $input);

        $response->assertStatus(500);

    }

    /**
     * User visits edit page and updates the author
     *
     * @return void
     */
    public function testAuthorsEditAndUpdatePage()
    {
        $author = factory(\App\Author::class)->create();
        $user = factory(User::class)->create();
        
        $responseEdit = $this->actingAs($user)->get('/authors/'.$author->id.'/edit');
        $responseEdit->assertStatus(200);

        $responseUpdate = $this->actingAs($user)->patch('/authors/'.$author->id, ['name' => 'Lorem ipsum Test Update']);
        $this->assertDatabaseHas('authors', ['name' => 'Lorem ipsum Test Update']);
        $responseUpdate->assertStatus(302);
        $responseUpdate->assertRedirect('/authors');
        $responseUpdate->assertSessionHasNoErrors();
        
        $responseUpdateError = $this->actingAs($user)->patch('/authors/'.$author->id, ['name' => '']);
        $responseUpdateError->assertStatus(302);
        $responseUpdateError->assertSessionHasErrors();
        
        $this->assertDatabaseHas('authors', ['name' => 'Lorem ipsum Test Update']);
    }


    /**
     * User deletes the author
     *
     * @return void
     */
    public function testAuthorsDestroyPage()
    {
        $author = factory(\App\Author::class)->create();
        $user = factory(User::class)->create();
        
        $responseDestroy = $this->actingAs($user)->delete('/authors/'.$author->id);
        $responseDestroy->assertStatus(302);
        $responseDestroy->assertSessionHasNoErrors();
        $this->assertDatabaseMissing('authors', ['id' => $author->id]);
    }   
}
