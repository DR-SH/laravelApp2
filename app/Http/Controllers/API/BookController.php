<?php

namespace App\Http\Controllers\API;

use App\Rules\ExistsInAuthorTable;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Book;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\Book as BookResource;

/**
 * Class BookController
 * @package App\Http\Controllers\API
 */
class BookController extends Controller
{

    /**
     * Display the list of books.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $books = BookResource::collection(Book::all());

        if($books->isNotEmpty()){
            return Response::json($books, 200);
        }
        return Response::json(['response' => 'Книг не найдено'], 400);
    }

    /**
     * Display the specified book.
     * 
     * @param Book $book
     * @return \Illuminate\Http\JsonResponse
     */
    
    public function show($book)
    {
        return Response::json($book, 200);
    }
    
    /**
     * Update the specified book in storage.
     *
     * @param Request $request
     * @param Book $book
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $book)
    {
        $validator = Validator::make($request->all(), [
            'title'=>'regex:/^[a-zа-я\s]+$/iu|min:3',
            'about'=>'min:3',
            'authors' => 'array',
            'authors.*' => new ExistsInAuthorTable,
        ]);

        if ($validator->fails()) {
            return Response::json(['response' => 'Данные заполнены некорректно'], 400);
        }
        
        $book->update($request->all());
        $this->syncAuthors($book, $request->input('authors'));
        return Response::json(new BookResource($book), 200);

    }

    /**
     *  Delete the specified book from storage.
     * 
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($book)
    {
        $book->delete();
        return Response::json(['response' => 'Книга удалена'], 200);
    }

}
