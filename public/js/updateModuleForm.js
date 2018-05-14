/**
 | This provides simple, convenient CSRF protection for  AJAX based  MODULE-UPDATE
 */

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$('#submit-update-module').submit(function(event){
    event.preventDefault();
    $.ajax({
        url: '/Courses/' + courseID +'/Modules/' + moduleID +'/update',
        type: 'POST',
        dataType: 'JSON',
        data: {
            title       : $('input[name = title]').val(),
            commitment  : $('#inputCommitment').val(),
            introduction: $('#inputModuleIntroduction').val(),
            module_order: $('#inputOrder').val()
        },
        success: function(response){
            $('.error-msg').remove(); // To clear the old error messages before update the module
            $('#response-message-success').show().text(response.message).show();
            $('#form-module-title-child').remove();
            $('#form-module-title-parent').append('<Span id="form-module-title-child">' + response.data.title + '</span>');
        },
        error: function(response){
            $('.error-msg').remove(); // To clear the old error messages before update the module
            $('#response-message-success').hide();
            $.each(response.responseJSON, function(key, val){
                $('input[name=' + key +']').after('<span  class= "error-msg text-danger">' + val +'</span>');
                $('textarea[name=' + key +']').after('<span  class= "error-msg text-danger">' + val +'</span>');
            })
        }
    });

});