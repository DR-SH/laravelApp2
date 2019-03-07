<?php

namespace App\Http\Controllers;
use App\Book;
use App\Author;
use Illuminate\Http\Request;
Use App\Http\Requests\BookRequest;

/**
 * Class BookController
 * @package App\Http\Controllers
 */
class BookController extends Controller
{
    const BOOK_CREATE = 'Была создана книга: ';
    const BOOK_UPDATE = 'Была отредактирована книга: ';
    const BOOK_DELETE = 'Была удалена книга: ';
    
    /**
     * Display a listing of the books.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = Book::orderBy('id', 'desc')->paginate(6);
        return view('books/index', ['books' => $books]);
    }

    /**
     * Show the form for creating a new book.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $authors = Author::all();
        return view('books/create', ['authors' => $authors]);
    }

    /**
     * Store a newly created book in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BookRequest $request)
    {

        $book = $this->updateOrCreate($request, \App\Book::class);

        $this->syncAuthors($book, $request->input('authors'));

        return redirect('books')->with('flash_msg', self::BOOK_CREATE.$book->title);
    }
    
    /**
     * Show the form for editing the specified book.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($book)
    {
        $authors = Author::all();
        return view('books/edit', ['book'=> $book, 'authors' => $authors]);
    }

    /**
     * Update the specified book in storage.
     *
     * @param BookRequest|Request $request
     * @param $book
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function update(BookRequest $request, $book)
    {
        $book = $this->updateOrCreate($request, \App\Book::class, $book->id);

        $this->syncAuthors($book, $request->input('authors'));

        return redirect('books')->with('flash_msg', self::BOOK_UPDATE.$book->title);
    }


    /**
     * Delete the specified book from storage
     *
     * @param Book $book
     *
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Book $book)
    {
        $book->delete();

        return redirect('books')->with('flash_msg', self::BOOK_DELETE.$book->title);
    }



    
}