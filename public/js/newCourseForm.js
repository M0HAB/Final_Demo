
/**
    | This provides simple, convenient CSRF protection for  AJAX based new course creation
 */

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$('#submit-new-course').submit(function(event){
    event.preventDefault();

    $.ajax({
        url: 'addNewCourse',
        type: 'POST',
        dataType: 'JSON',
        data: {
            title     : $('input[name = title]').val(),
            code      : $('input[name = code]').val(),
            start_date: $('input[name = start_date]').val(),
            end_date  : $('input[name = end_date]').val(),
            course_specialization : $('#inputCourseSpecialization').val(),
            course_language       : $('#inputCourseLanguage').val(),
            course_department     : $('#inputCourseDepartment').val(),
            commitment            : $('#inputCommitment').val(),
            description: $('#inputCourseDescription').val(),
            how_to_pass: $('#inputHowToPass').val()
        },
        success: function(response){
            $('.error-msg').remove(); // To clear the old error messages before submit new course
            $('#response-message-success').text(response.message).show();
            $('input').val('');
            $('select').val('');
            $('textarea').val('');
        },
        error: function(response){
            $('.error-msg').remove(); // To clear the old error messages before submit new course
            $.each(response.responseJSON, function(key, val){
                $('input[name=' + key +']').after('<span  class= "error-msg text-danger">' + val +'</span>');
                $('select[name=' + key +']').after('<span  class= "error-msg text-danger">' + val +'</span>');
                $('textarea[name=' + key +']').after('<span  class= "error-msg text-danger">' + val +'</span>');
            })
        }
    });


});
