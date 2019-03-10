<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Support\Str;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

/**
 * Class ApiTest
 * @package Tests\Feature
 */
class ApiTest extends TestCase
{

    use DatabaseTransactions;

    /**
     * User can see list of books and one book 
     *
     * @return void
     */
    public function testBooksListAndItem()
    {
        $token = Str::random(60);
        $books = factory(\App\Book::class, 5)->create();
        $user = factory(User::class)->create(['api_token' => hash('sha256', $token)]);

        $responseList = $this->withHeaders([
                    'Authorization' => 'Bearer '.$token,
                    'Accept' => 'application/json'])
                          ->get('/api/v1/books/list');
        $responseList->assertStatus(200);

        $responseItem = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
            'Accept' => 'application/json'])
                             ->get('/api/v1/books/by-id/'.$books->first()->id);
        $responseItem->assertStatus(200);

    }

    /**
     * User updates book
     * 
     * @return void
     */
    public function testBooksUpdate()
    {
        $token = Str::random(60);
        $book = factory(\App\Book::class)->create();
        $user = factory(User::class)->create(['api_token' => hash('sha256', $token)]);       
        
        $responseUpdate = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
            'Accept' => 'application/json'])
            ->post('/api/v1/books/update/'.$book->id, ['title' => 'Test Api Title']);
        $responseUpdate->assertStatus(200);
        $this->assertDatabaseHas('books', ['title'=>'Test Api Title']);
    }

    /**
     * User deletes book
     *
     * @return void
     */
    public function testBooksDelete()
    {
        $token = Str::random(60);
        $book = factory(\App\Book::class)->create();
        $user = factory(User::class)->create(['api_token' => hash('sha256', $token)]);

        $responseDestroy = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json'])
            ->delete('/api/v1/books/'.$book->id);
        $responseDestroy->assertStatus(200);
        $this->assertDatabaseMissing('books', ['id' => $book->id]);


    }
}
