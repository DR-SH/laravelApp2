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
     * @param integer $id
     * @return \Illuminate\Http\JsonResponse
     */
    
    public function show($id)
    {
        $book = new BookResource(Book::find($id));
        if($book->resource){
            return Response::json($book, 200);
        }
        return Response::json(['response' => 'Книги с таким id не найдено'], 400);
    }
    
    /**
     * Update the specified book in storage.
     *
     * @param Request $request
     * @param integer $id
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
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

        $book = new BookResource(Book::find($id));

        if($book->resource){

            $this->updateOrCreate($request, \App\Book::class, $id);
            $this->syncAuthors($book->resource, $request->input('authors'));
            return Response::json(new BookResource(Book::find($id)), 200);

        }
        return Response::json(['response' => 'Такой книги не найдено'], 400);
    }


    /**
     *  Delete the specified book from storage.
     * 
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id)
    {
        $book = Book::where('id', $id);
        
        if($book->get()->isNotEmpty()){
            $book->delete();
            return Response::json(['response' => 'Книга удалена'], 200);
        }
        return Response::json(['response' => 'Такой книги не существует'], 400);
    }

}
