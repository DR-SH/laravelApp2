@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @include('layouts/partials/flash')
                <p><a href="{{ action('BookController@create')}}">Создать новую книгу</a></p>
                @if($books->isNotEmpty())
                    <h1>Список книг</h1>
                    @foreach($books as $book)
                        <div class="m-5">
                            <h3><a href="{{ action('BookController@edit', [$book->id]) }}">{{$book->title}}</a></h3>
                            <p>{{$book->about}}</p>
                            <ul class="list-group">
                                @foreach($book->authors as $author)
                                    <li class="list-group-item"><a href="{{ action('AuthorController@edit', [$author->id]) }}">{{ $author->name }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    @endforeach
                    <div>{{ $books->links() }}</div>
                 @endif
            </div>
        </div>
    </div>
@endsection