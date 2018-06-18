


$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$('#submit-course-activation').submit(function(event){
    event.preventDefault();
    $.ajax({
        url: '/Courses/' + courseID +'/updateActivation',
        type: 'POST',
        dataType: 'JSON',
        data: {
            is_active     : $('input[name = is_active]').val()
        },
        success: function(data){
            console.log(data);
            console.log(data.course.is_active);
            if(data.course.is_active){
                $('input[name = is_active]').val('0');
                $('#submit-course-status').html('Deactivate the Course');
                $('#icon-course-status').removeClass('fa-toggle-off').addClass('fa-toggle-on text-success')
            }else{
                $('input[name = is_active]').val('1');
                $('#submit-course-status').html('Activate the Course');
                $('#icon-course-status').removeClass('Òfa-toggle-on text-success').addClass('fa-toggle-off')
            }
        },
        error: function(response){
            console.log(typeof(response.data));
            $('#response-message-success').hide();
            $('#response-message-danger').show().text(response.message).show();
        }
    }).done(function(data){
        if ($.isEmptyObject(data.error)) {
            toastr.success(data.success);
        }
    });
});
$body = $("body");
$(document).on({
    ajaxStart: function() { $body.addClass("loading");   },
    ajaxStop: function() { $body.removeClass("loading"); }
});
