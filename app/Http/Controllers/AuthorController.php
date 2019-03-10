<?php

namespace App\Http\Controllers;
use App\Book;
use App\Author;
use Illuminate\Http\Request;
Use App\Http\Requests\AuthorRequest;

/**
 * Class AuthorController
 * @package App\Http\Controllers
 */
class AuthorController extends Controller
{

    /**
     * @var string AUTHOR_CREATE
     */
    const AUTHOR_CREATE = 'Был создан автор: ';

    /**
     * @var string AUTHOR_UPDATE
     */
    const AUTHOR_UPDATE = 'Был отредактирован автор: ';
    
    /**
     * @var string AUTHOR_DELETE
     */
    const AUTHOR_DELETE = 'Был удалён автор: ';
    
    /**
     * Display a listing of the authors.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $authors = Author::orderBy('id', 'desc')->paginate(8);
        return view('authors/index', ['authors' => $authors]);
    }

    /**
     * Show the form for creating a new author.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $books = Book::all();
        return view('authors/create', ['books' => $books]);
    }

    /**
     * Store a newly created author in storage.
     *
     * @param \App\Http\Requests\AuthorRequest
     *
     * @return \Illuminate\Http\Response redirect
     */
    public function store(AuthorRequest $request)
    {
        $author = Author::create($request->all());

        if ($request->has('books') ){
            $this->syncBooks($author, $request->input('books'));
        }

        return redirect('authors')->with('flash_msg', self::AUTHOR_CREATE.$author->name);
    }


    /**
     * Show the form for editing the specified author.
     *
     * @param Author $author
     * @return \Illuminate\Http\Response
     */
    public function edit($author)
    {
        $books = Book::all();
        return view('authors/edit', ['author'=> $author, 'books' => $books]);
    }

    /**
     * Update the specified author in storage.
     *
     * @param AuthorRequest $request
     * @param Author $author
     * @return \Illuminate\Http\Response
     */
    public function update(AuthorRequest $request, $author)
    {

        $author->update($request->all());
        $request->has('books') ? $this->syncBooks($author, $request->input('books')) : $this->detachBooks($author);

        return redirect('authors')->with('flash_msg', self::AUTHOR_UPDATE.$author->name);
    }

    /**
     * Remove the specified author from storage.
     *
     * @param  collection
     * @return \Illuminate\Http\Response redirect
     */
    public function destroy($author)
    {
        $author->delete();

        return redirect('authors')->with('flash_msg', self::AUTHOR_DELETE.$author->name);
    }

    /**
     * Syncronize relation between books and authors.
     *
     * @param Author $author
     * @param array $array
     * @return boolean
     */
    public function syncBooks(Author $author, array $array = [])
    {
        return $array == [] ? 0 : $author->books()->sync($array);
    }

    /**
     * Detach relation between books and authors.
     *
     * @param Author $author
     * @return boolean
     */
    public function detachBooks(Author $author)
    {
        return $author->books()->detach();
    }
}
