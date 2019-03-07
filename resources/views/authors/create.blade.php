@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h1>Страница создания нового автора</h1>
                <form method="POST" action = '{{action('AuthorController@store')}}'>


                    @include('authors.partials.form', ['name'=> '',
                                                     'booksIds' => [],
                                                     'books' => $books,
                                                     'submitButText' => 'Создать'
                                                      ])
                </form>
            </div>
        </div>
    </div>
@endsection
