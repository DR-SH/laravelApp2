<?php

namespace App\Http\Controllers;

use App\Book;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * syncronized relation between books and authors
     *
     * @param Book $book
     * @param array $array
     *
     * @return boolean
     */
    public function syncAuthors(Book $book, $array = [])
    {
        return $array == [] ?  0 : $book->authors()->sync($array);
    }
}
