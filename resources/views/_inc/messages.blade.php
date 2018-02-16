@if (Session('status'))
    <div class="alert alert-dismissible alert-success">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        {{ Session('status') }}
    </div>
@endif