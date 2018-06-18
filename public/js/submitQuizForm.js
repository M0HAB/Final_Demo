


$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$('#submit-quiz-activation').submit(function(event){
    event.preventDefault();
    $.ajax({
        url: '/Quizzes/' + quizID +'/updateActivation',
        type: 'POST',
        dataType: 'JSON',
        data: {
            is_active     : $('input[name = is_active]').val()
        },
        success: function(data){
            console.log(data);
            console.log(data.quiz.is_active);
            if(data.quiz.is_active){
                $('input[name = is_active]').val('0');
                $('#submit-quiz-status').html('Deactivate the quiz');
                $('#quiz-status').html('Activated quiz').removeClass('bg-danger').addClass('bg-success');
            }else{
                $('input[name = is_active]').val('1');
                $('#submit-quiz-status').html('Activate the quiz');
                $('#quiz-status').html('Deactivated quiz').removeClass('bg-success').addClass('bg-danger');

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
