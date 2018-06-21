/**
 | This provides simple, convenient CSRF protection for  AJAX based new course creation
 */

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$( document ).ready(function () {
    $('.deps').hide();
    $('.specs').hide();
    dep_id = $('select#inputCourseDepartment').val();
    spec_id = $('select#inputCourseSpecialization').val();
    $('.dep-'+spec_id).show();
    $('.spec-'+dep_id).show();
});
$('select#inputCourseSpecialization').on('change', function(){
    let id = $(this).val();
    if(id == 0){
        $('.deps').show();
    }else{
        if(!$('select#inputCourseDepartment :selected').hasClass('dep-'+id)){
            $('select#inputCourseDepartment').val(0);
        }
        $('.deps').hide();
        $('.dep-'+id).show();
    }
});
$('select#inputCourseDepartment').on('change', function(){
    let id = $(this).val();
    if(id == 0){
        $('.specs').show();
    }else{
        if(!$('select#inputCourseSpecialization :selected').hasClass('spec-'+id)){
            $('select#inputCourseSpecialization').val(0);
        }
        $('.specs').hide();
        $('.spec-'+id).show();
    }
});
$('#submit-update-course').submit(function(event){
    event.preventDefault();
    var courseID = $('#course-id').val();
    $.ajax({
        url: '/Courses/' + courseID +'/update',
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
            $('#form-course-title-child').remove();
            $('#form-course-title-parent').append('<Span id="form-course-title-child">' + response.course.title + '</span>');
        },
        error: function(response){
            if(response.responseText === "Unauthorized"){
                toastr.error("Unauthorized Operation");
            }
            $('.error-msg').remove(); // To clear the old error messages before submit new course
            $('#response-message-success').hide();
            $.each(response.responseJSON, function(key, val){
                $('input[name=' + key +']').after('<span  class= "error-msg text-danger">' + val +'</span>');
                $('select[name=' + key +']').after('<span  class= "error-msg text-danger">' + val +'</span>');
                $('textarea[name=' + key +']').after('<span  class= "error-msg text-danger">' + val +'</span>');
            })
        }
    }).done(function(data){
        if ($.isEmptyObject(data.error)) {
            toastr.success(data.success);
        }
    });
});
