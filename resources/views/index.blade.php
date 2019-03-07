@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @include('layouts/partials/flash')
                <h1>Главная страница со списков авторов</h1>
                @foreach($authors as $author)
                    <div class="m-2 p-4 jumbotron col-12">
                        <h3 class="display-6">{{$author->name}}</h3>
                        @if($author->books->isNotEmpty())
                            <ul>
                                @foreach($author->books as $book)
                                    <li>{{$book->title}}</li>
                                @endforeach
                            </ul>
                        @else
                            <p>У автор пока нет книг</p>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection