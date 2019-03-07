@if($errors->any())
    <ul class='alert alert-dark'>
        @foreach($errors->all() as $error)
            <li>{{$error}}</li>
        @endforeach
    </ul>
@endif