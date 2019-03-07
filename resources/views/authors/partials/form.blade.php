@include('layouts.partials.errors')
<input type="hidden" name="_token" value="{{ csrf_token() }}">
<div class="form-group">
    <label for="name">Имя автора</label>
    <input type="text" class="form-control" id="name" name="name" aria-describedby="emailHelp"
           placeholder="Имя" value = "{{$name}}">
</div>

<div class="form-group">
    <label for="formAuthors">Книги:</label>
    <select multiple class="form-control" id="formBooks"  name="books[]">
        @foreach($books as $book)
            <option value="{{$book->id}}"
                    @if(in_array($book->id, $booksIds))selected="selected"@endif>
                {{$book->title}}</option>
        @endforeach
    </select>
</div>

<button type="submit" class="btn btn-primary" >{{$submitButText}}</button>