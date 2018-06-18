
/**
 | This provides simple, convenient CSRF protection for  AJAX based new course creation
 */

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$('#submit-new-module').submit(function(event){
    event.preventDefault();

    $.ajax({
        url: 'addNewModule',
        type: 'POST',
        dataType: 'JSON',
        data: {
            title        :  $('input[name = title]').val(),
            commitment   :  $('#inputCommitment').val(),
            module_order :  $('#inputOrder').val(),
            introduction :  $('#inputModuleIntroduction').val(),
        },
        success: function(response){
            $('.error-msg').remove(); // To clear the old error messages before submit new course
            $('input').val('');
            $('textarea').val('');
        },
        error: function(response){
            $('.error-msg').remove(); // To clear the old error messages before submit new course
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
