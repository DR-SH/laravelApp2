@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @include('layouts/partials/flash')
                <p><a href="{{ action('AuthorController@create')}}">Создать нового автора</a></p>
                @if($authors->isNotEmpty() )
                    <h1>Список авторов</h1>

                    @foreach($authors as $author)
                        <div class="m-5">
                            <h3><a href="{{ action('AuthorController@edit', [$author->id]) }}">{{$author->name}}</a></h3>
                            <p>Книг: {{$author->books()->count()}}</p>
                            <ul class="list-group">
                                @foreach($author->books as $book)
                                    <li class="list-group-item"><a href="{{ action('BookController@edit', [$book->id]) }}">{{ $book->title }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    @endforeach
                    <div>{{ $authors->links() }}</div>
                @endif
            </div>
        </div>
    </div>
@endsection
