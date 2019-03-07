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
     * creating new model or updating if exists
     *
     * @param Request $request
     * @param Class 
     * @param int $id
     * @return boolean
     */
    protected function updateOrCreate($request, $model, $id = 0)
    {
        return $model::updateOrCreate(['id' => $id], $request->all());
    }

    /**
     * syncronized relation between books and authors
     *
     * @param Book $book
     * @param array $array
     *
     * @return boolean
     */
    protected function syncAuthors($book, $array = [])
    {
        return $array == [] ?  0 : $book->authors()->sync($array);
    }
}
