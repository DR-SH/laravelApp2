<fieldset disabled>
    <div class="form-group">
        <label for="created_at">Занесена в базу</label>
        <input type="text" class="form-control" id="created_at" aria-describedby="emailHelp"
               value = "{{$created}}">
    </div>
    <div class="form-group">
        <label for="updated_at">Последнее изменение</label>
        <input type="text" class="form-control" id="updated_at" aria-describedby="emailHelp"
               value = "{{$updated}}">
    </div>
</fieldset>