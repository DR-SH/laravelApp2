<form method = 'POST' action = '{{action('AuthorController@destroy', $author->id)}}'>
    <input name="_method" type="hidden" value="DELETE">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <button type="submit" class="btn btn-danger">Удалить автора</button>
</form>