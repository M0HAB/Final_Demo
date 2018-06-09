


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
            is_active     : $('input[name = is_active]').val(),
        },
        success: function(response){
            $('#response-message-success').show().text(response.message).show();
            console.log(typeof(response.data) );
            if(response.data.is_active == '1') {
                $('#submit-course-status').remove();
                $('#submit-status').append('<button id="submit-course-status" class="text-success mt-2" style="border: none;background-color: transparent;cursor: pointer">Deactivate The Course</button>');
                $('input[name = is_active]').val('0');
                $('#icon-course-status').removeClass('fa-toggle-off').addClass('fa-toggle-on text-success');


            }else{
                $('#submit-course-status').remove();
                $('#submit-status').append('<button id="submit-course-status" class="text-success mt-2" style="border: none;background-color: transparent;cursor: pointer">Activate The Course</button>');
                $('input[name = is_active]').val('1');
                $('#icon-course-status').removeClass('fa-toggle-on text-success').addClass('fa-toggle-off');

            }
        },
        error: function(response){
            console.log(typeof(response.data));
            $('#response-message-success').hide();
            $('#response-message-danger').show().text(response.message).show();
        }
    });
})
$body = $("body");
$(document).on({
    ajaxStart: function() { $body.addClass("loading");   },
    ajaxStop: function() { $body.removeClass("loading"); }
});
