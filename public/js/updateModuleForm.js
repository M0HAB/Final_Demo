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
            console.log(response);
            $('.error-msg').remove(); // To clear the old error messages before update the module
            $('#form-module-title-child').remove();
            $('#form-module-title-parent').append('<Span id="form-module-title-child">' + response.module.title + '</span>');
        },
        error: function(response){
            $('.error-msg').remove(); // To clear the old error messages before update the module
            $.each(response.responseJSON, function(key, val){
                $('input[name=' + key +']').after('<span  class= "error-msg text-danger">' + val +'</span>');
                $('textarea[name=' + key +']').after('<span  class= "error-msg text-danger">' + val +'</span>');
            })
        }
    }).done(function(data){
        if ($.isEmptyObject(data.error)) {
            toastr.success(data.success);
        }
    });

});