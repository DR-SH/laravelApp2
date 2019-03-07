<?php

namespace App\Http\Controllers;
use App\Book;
use App\Author;
use Illuminate\Http\Request;
Use App\Http\Requests\AuthorRequest;
class AuthorController extends Controller
{

    const AUTHOR_CREATE = 'Был создан автор: ';
    const AUTHOR_UPDATE = 'Был отредактирован автор: ';
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
        $author = $this->updateOrCreate($request, \App\Author::class);

        if ($request->has('books') ){
            $this->syncBooks($author, $request->input('books'));
        }

        return redirect('authors')->with('flash_msg', self::AUTHOR_CREATE.$author->name);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($author)
    {
        $books = Book::all();
        return view('authors/edit', ['author'=> $author, 'books' => $books]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param AuthorRequest $request
     * @param Author $author
     * @return \Illuminate\Http\Response
     */
    public function update(AuthorRequest $request, $author)
    {
        $author = $this->updateOrCreate($request, \App\Author::class, $author->id);

        $request->has('books') ? $this->syncBooks($author, $request->input('books')) : $this->detachBooks($author);

        return redirect('authors')->with('flash_msg', self::AUTHOR_UPDATE.$author->name);
    }

    /**
     * Remove the specified resource from storage.
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
     * syncronized relation between books and authors
     *
     * @param Author $author
     *   
     * @return boolean 
     * @internal param Book $book
     */
    private function syncBooks(Author $author, array $array = [])
    {
        return $author->books()->sync($array);
    }

    /**
     * syncronized relation between books and authors
     *
     * @param Author $author
     *
     * @return boolean
     */
    private function detachBooks(Author $author)
    {
        return $author->books()->detach();
    }
}
