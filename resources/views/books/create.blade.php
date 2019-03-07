@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h1>Создание новой книги</h1>
                <form method="POST" action = '{{action('BookController@store')}}'>


                    @include('books.partials.form', ['title'=> '',
                                                     'about' => '',
                                                     'authorsIds' => [],
                                                     'authors' => $authors,
                                                     'submitButText' => 'Создать'
                                                      ])
                </form>
            </div>
        </div>
    </div>
@endsection