@if(session()->has('flash_msg'))
    <div class="container flashMess">
        <div class="alert alert-dark">{{session()->get('flash_msg')}}</div>
    </div>
@endif