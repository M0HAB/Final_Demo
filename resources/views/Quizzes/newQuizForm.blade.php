@extends('_layouts.app')

@section('title')
    Add New Quiz
@endsection

@section('styles')
    <style>

        /* Start by setting display:none to make this hidden.
   Then we position it in relation to the viewport window
   with position:fixed. Width, height, top and left speak
   for themselves. Background we set to 80% white with
   our animation centered, and no-repeating */
        .modal {
            display:    none;
            position:   fixed;
            z-index:    1000;
            top:        0;
            left:       0;
            height:     100%;
            width:      100%;
            background: rgba( 255, 255, 255, .8 )
            url('{{ asset('course_images/ajax-loader2.gif') }}')
            50% 50%
            no-repeat;
        }

        /* When the body has the loading class, we turn
           the scrollbar off with overflow:hidden */
        body.loading .modal {
            overflow: hidden;
        }

        /* Anytime the body has the loading class, our
           modal element will be visible */
        body.loading .modal {
            display: block;
        }

    </style>
@endsection

@section('content')
    <div class="content mt-5 mb-5">
        <div class="container">
            <div id="response-message-success" class="alert alert-success" style="display: none"></div>
            <fieldset>
                <div class="reg-log-form p-3 my-3">
                    <legend><i class="fa fa-plus"></i> Add New Quiz</legend>
                    <hr>
                    <form id="submit-new-quiz">
                        <h5 class="text-muted  font-weight-bold border-left p-1">First Step: Insert the quiz basic info<i class="fas fa-arrow-down ml-1"></i></h5>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="inputTitle">Quiz Title</label>
                                    <input required="true" type="text" name="title" class="form-control" id="inputTitle"   placeholder="Enter the quiz title">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="inputDeadline">Deadline</label>
                                    <input required="true" type="date" name="deadline" class="form-control" id="inputDeadline"   placeholder="Enter the deadline">
                                </div>
                            </div>
                        </div>
                        <br>
                        <hr>
                        <h5 class="text-muted  font-weight-bold border-left p-1">Second Step: Insert the questions & answers  of the quiz<i class="fas fa-arrow-down ml-1"></i></h5>
                        <hr>
                        <div id="array-errors" style="display: none" class="alert alert-danger"></div>
                        <div class=" border-success p-2" style="border-left-style: groove">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="inputQuestion">Question <span id="question_number" class="badge badge-primary">1</span></label>
                                        <input required="true" type="text" name="questions[]" class="form-control" id="inputQuestion"   placeholder="Enter the Question">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="inputFirstAnswer">Choice <span class="badge badge-success">#1</span></label>
                                        <input required="true" type="text" name="first_choices[]" class="form-control" id="inputFirstAnswer"   placeholder="Enter the First choice">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="inputSecondAnswer">Choice <span class="badge badge-success">#2</span></label>
                                        <input required="true" type="text" name="second_choices[]" class="form-control" id="inputSecondAnswer"   placeholder="Enter the Second choice">

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="inputThirdAnswer">Choice <span class="badge badge-success">#3</span></label>
                                        <input required="true" type="text" name="third_choices[]" class="form-control" id="inputThirdAnswer"   placeholder="Enter the Third choice">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="inputFourthAnswer">Choice <span class="badge badge-success">#4</span></label>
                                        <input required="true" type="text" name="fourth_choices[]" class="form-control" id="inputFourthAnswer"   placeholder="Enter the Fourth choice">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="inputPoints">Question Points</label>
                                        <input required="true" type="text" name="question_points[]" class="form-control" id="inputPoints"   placeholder="Enter the question points">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="inputCorrectAnswer">Correct Choice</label>
                                        <select required="true" name="correct_choices[]" class="form-control" id="inputCorrectAnswer"  style="width: 100%">
                                            <option value="">Select The Correct Choice..</option>
                                            <option value="1">Choice #1</option>
                                            <option value="2">Choice #2</option>
                                            <option value="3">Choice #3</option>
                                            <option value="4">Choice #4</option>
                                        </select>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div id="new-question-div"></div>
                        <p class="text-right mt-4"><button type="button" onclick="createNewQuestion()" class="font-weight-bold btn  text-success border border-success p-2" style="background-color: white"><i class="fa fa-plus mr-1"></i>Add question</button></p>
                        <hr>
                        <div class="row">
                            <div class="col-md-3">
                                <br>
                                <button type="submit" class="btn btn-primary">Create New Quiz</button>
                            </div>
                        </div>
                    </form>
                </div>
            </fieldset>
        </div>
        <div class="modal"><!-- Place at bottom of page --></div>
    </div>
@endsection

@section('scripts')
    <script>
        var courseID = {!! json_encode($course->id) !!};
        var moduleID = {!! json_encode($module->id) !!};
    </script>
    <script src="{{ asset('js/newQuizForm.js') }}"></script>
    <script>
        $body = $("body");
        $(document).on({
            ajaxStart: function() { $body.addClass("loading"); },
            ajaxStop: function() { $body.removeClass("loading"); }
        });
    </script>
@endsection