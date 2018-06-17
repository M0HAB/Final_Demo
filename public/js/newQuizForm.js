
var question_number = 1;
var total_questions = 1;
function createNewQuestion(){
    question_number ++;
    var new_question =  '<hr><div class="p-2">' +
        '<div class="row">' +
        '<div class="col-md-12">' +
        '<div class="form-group">' +
        '<label for="inputQuestion" class="font-weight-bold">Question <span class="badge badge-primary" id="question_number_' + question_number  +'"></span></label>' +
        '<input type="text" name="questions[]" class="form-control" id="inputQuestion" placeholder="Enter the Question">' +
        '</div></div> <div class="col-md-6"> <div class="form-group"> <label for="inputFirstAnswer">Choice <span class="badge badge-success">#1</span></label>' +
        '<input type="text" name="first_choices[]" class="form-control" id="inputFirstAnswer"   placeholder="Enter the First choice"> </div> </div>'+
        '<div class="col-md-6"> <div class="form-group"> <label for="inputSecondAnswer">Choice <span class="badge badge-success">#2</span></label>' +
        '<input type="text" name="second_choices[]" class="form-control" id="inputSecondAnswer"   placeholder="Enter the Second choice">' +
        '</div> </div> <div class="col-md-6"> <div class="form-group"> <label for="inputThirdAnswer">Choice <span class="badge badge-success">#3</span></label> <input type="text" name="third_choices[]" class="form-control" id="inputThirdAnswer"   placeholder="Enter the Third choice">' +
        '</div> </div> <div class="col-md-6"> <div class="form-group"> <label for="inputFourthAnswer">Choice <span class="badge badge-success">#4</span></label> <input type="text" name="fourth_choices[]" class="form-control" id="inputFourthAnswer"   placeholder="Enter the Fourth choice"> </div> </div>' +
        '<div class="col-md-3"> <div class="form-group"> <label for="inputCorrectAnswer">Correct Answer</label> <select name="correct_choices[]" class="form-control" id="inputCorrectAnswer"  style="width: 100%"> <option value="">Select Correct answer..</option> <option value="1">Choice #1</option> <option value="2">Choice #2</option> <option value="3">Choice #3</option> <option value="4">Choice #4</option> </select> </div> </div>' +
        '<div class="col-md-3"> <div class="form-group"> <label for="inputPoints">Question Points</label> <input type="text" name="question_points[]" class="form-control" id="inputPoints"   placeholder="Enter the question points"> </div> </div></div></div>'
    $('#new-question-div').append(new_question);
    $('#question_number_' + question_number).text(question_number)
}

/**
 | This provides simple, convenient CSRF protection for  AJAX based new quiz creation
 */

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$('#submit-new-quiz').submit(function(event){
    event.preventDefault();
    var total_points = 0;
    $("input[name = 'question_points[]']").each(function(){
        total_points = parseInt($(this).val()) + total_points;
    });
    console.log(total_points);
    $.ajax({
        url: '/Courses/' + courseID +'/Modules/' + moduleID +'/addNewQuiz',
        type: 'POST',
        dataType: 'JSON',
        data: {
            title : $('input[name = title]').val(),
            deadline : $('input[name = deadline]').val(),
            total_grade: total_points,
            questions : $("input[name='questions[]']").map(function(){return $(this).val();}).get(),
            first_choices : $("input[name='first_choices[]']").map(function(){return $(this).val();}).get(),
            second_choices : $("input[name='second_choices[]']").map(function(){return $(this).val();}).get(),
            third_choices : $("input[name='third_choices[]']").map(function(){return $(this).val();}).get(),
            fourth_choices : $("input[name='fourth_choices[]']").map(function(){return $(this).val();}).get(),
            correct_choices : $("select[name='correct_choices[]']").map(function(){return $(this).val();}).get(),
            question_points : $("input[name = 'question_points[]']").map(function(){return $(this).val();}).get(),
        },
        success: function(response){
            $('#array-errors').hide();
            $('#response-message-success').show().text(response.message).show();
            $('input').val('');
            $('select').val('');
        },
        error: function(response){
            $('#array-errors').hide();
            $('.error-msg').remove(); // To clear the old error messages before submit new course
            $('#response-message-success').hide();
            $.each(response.responseJSON, function(key, val){
                if(key == 'title' || key == 'deadline' || key == 'weight'){
                    $('input[name=' + key +']').after('<span  class= "error-msg text-danger">' + val +'</span>');
                    $('select[name=' + key +']').after('<span  class= "error-msg text-danger">' + val +'</span>');
                    $body.removeClass("loading")
                }else{
                    $('#array-errors').show();
                    $("#array-errors").text(val);
                }
            })
        }
    });

});
