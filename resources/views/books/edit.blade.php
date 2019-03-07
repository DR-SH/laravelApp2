@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h1>Редактирование книги</h1>
                <form method = 'POST' action = '{{action('BookController@update', $book->id)}}'>
                    <input name="_method" type="hidden" value="PATCH">


                    @include('books.partials.form', ['title'=> $book->title,
                                                     'about' => $book->about,
                                                     'authorsIds' => $book->authorsIds(),
                                                     'authors' => $authors,
                                                     'submitButText' => 'Редактировать'
                                                      ])
                    @include('layouts.partials.disabled', ['created'=> $book->created_at,
                                                     'updated'=> $book->updated_at])

                </form>

                @include('books.partials.delete')
            </div>
        </div>
    </div>
@endsection