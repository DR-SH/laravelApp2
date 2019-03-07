<form method = 'POST' action = '{{action('BookController@destroy', $book->id)}}'>
    <input name="_method" type="hidden" value="DELETE">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <button type="submit" class="btn btn-danger">Удалить</button>
</form>