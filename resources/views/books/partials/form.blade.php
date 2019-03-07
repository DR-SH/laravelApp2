@include('layouts.partials.errors')
<input type="hidden" name="_token" value="{{ csrf_token() }}">
<div class="form-group">
    <label for="title">Название книги</label>
    <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp"
           placeholder="Название книги" value = "{{$title}}">
</div>
<div class="form-group">
    <label for="about">Аннотация</label>
                        <textarea class="form-control" id="about" name="about" aria-describedby="emailHelp"
                                  placeholder="Название книги">{{$about}}</textarea>
</div>

<div class="form-group">
    <label for="formAuthors">Авторы:</label>
    <select multiple class="form-control" id="formAuthors"  name="authors[]">
        @foreach($authors as $author)
            <option value="{{$author->id}}"
                    @if(in_array($author->id, $authorsIds))selected="selected"@endif>
                {{$author->name}}</option>
        @endforeach
    </select>
</div>

<button type="submit" class="btn btn-primary" >{{$submitButText}}</button>