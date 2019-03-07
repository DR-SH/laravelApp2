@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h1>Страница редактирования автора</h1>
                <form method = 'POST' action = '{{action('AuthorController@update', $author->id)}}'>
                    <input name="_method" type="hidden" value="PATCH">


                    @include('authors.partials.form', ['name'=> $author->name,
                                                     'booksIds' => $author->booksIds(),
                                                     'books' => $books,
                                                     'submitButText' => 'Редактировать'
                                                      ])

                    @include('layouts.partials.disabled', ['created'=> $author->created_at,
                                                     'updated'=> $author->updated_at])

                </form>

                @include('authors.partials.delete')
            </div>
        </div>
    </div>
@endsection