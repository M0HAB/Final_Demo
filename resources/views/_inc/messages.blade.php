{{--  Default messages  --}}
@if (Session('def-error'))
    <div class="alert alert-dismissible alert-danger">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        {{ Session('def-error') }}
    </div>
@endif

@if (Session('def-warning'))
    <div class="alert alert-dismissible alert-warning">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        {{ Session('def-warning') }}
    </div>
@endif

@if (Session('def-success'))
    <div class="alert alert-dismissible alert-success">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        {{ Session('def-success') }}
    </div>
@endif