@extends('_layouts.app')

@section('title')
    {{ $quiz->title }}
@endsection

@section('styles')
    <style>
        /*body{
            background-color: #fafbfc;
            height: auto;
        }*/
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
    <div class="row">
        <div class="col-sm-12 mb-3">
                <h1 class="text-primary f-rw mb-3 d-inline mb-3" style="letter-spacing: 2px">{{ $quiz->title }}</h1>
                @if(Auth::User()->isInstructor())
                    <span id="quiz-status" class="p-1 rounded text-white  {{ $quiz->is_active ? 'badge badge-success': 'badge badge-danger' }}" >{{ $quiz->is_active ? 'Activated quiz': 'Deactivated quiz' }}</span>
                @endif

                <div class="mt-2">
                    <p class="mb-1 bg-white"><span><strong>Due: </strong><span class="text-success"><strong>{{date('d-m-Y', strtotime($quiz->deadline))}}</strong></span></p>

                    <p class="mb-1 bg-white"><span><strong>Total questions: </strong></span><strong class="text-success mr-1">{{count($questions)}}</strong></p>

                    <p class="mb-1 bg-white"><span><strong>Total grade: </strong></span><span class="text-success"><strong>{{$quiz->total_grade}}</strong></span></p>
                </div>
                @if(Auth::User()->isInstructor() && canDelete('Quiz'))
                <form id="submit-quiz-activation">
                    @if(!$quiz->is_active)
                        <input type="hidden" name="is_active" value='1'>
                        <p id="submit-status">
                            <button type="submit" id="submit-quiz-status"  class="btn btn-primary mt-3">Activate the quiz</button>
                        </p>
                    @else
                        <input type="hidden" name="is_active" value='0'>
                        <p id="submit-status">
                            <button type="submit" id="submit-quiz-status"  class="btn btn-primary mt-3">Deactivate the quiz</button>
                        </p>
                    @endif
                </form>
            @endif
        </div>
    </div>
    <div class="border rounded bg-white mt-2 p-4">
       <form action="{{ route('quiz.submitQuizAnswer', ['course' => $course->id, 'module' => $module->id, 'quiz' => $quiz->id]) }}" method="post" enctype="multipart/form-data">
           {{ csrf_field() }}
           @for($i=0; $i < count($questions); $i++)
               <div class="row">
                   <div class="col-sm-12  font-weight-bold"><span class="badge badge-primary mr-1">{{$i+1}}</span>{{ $questions[$i]->question }}<span class="ml-2 badge badge-success p-1">{{$questions[$i]->question_points}} {{ $questions[$i]->question_points > 1? 'Points': 'point'}}</span></div>

                   <div class="col-sm-12 m-3 border-success   font-weight-bold">

                        <div class="custom-control custom-radio">
                            <input type="radio" id="customRadio-1" name="choices[{{ $i  }}]" value="1" class="custom-control-input">
                            <label class="custom-control-label" for="customRadio-1">{{ $questions[$i]->first_choice }}</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="customRadio-2" name="choices[{{ $i  }}]" value="2" class="custom-control-input">
                            <label class="custom-control-label" for="customRadio-2">{{ $questions[$i]->second_choice }}</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="customRadio-3" name="choices[{{ $i  }}]" value="3" class="custom-control-input">
                            <label class="custom-control-label" for="customRadio-3">{{ $questions[$i]->third_choice }}</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="customRadio-4" name="choices[{{ $i  }}]" value="3" class="custom-control-input">
                            <label class="custom-control-label" for="customRadio-4">{{ $questions[$i]->fourth_choice }}</label>
                        </div>
                        <input type="hidden" name="correct_choices[{{ $i  }}]" value="{{ $questions[$i]->correct_choice }}">
                        <input type="hidden" name="question_points[{{ $i  }}]" value="{{ $questions[$i]->question_points }}">

                       {{-- <input type="radio" required="true" name="choices[{{ $i  }}]" value="1"> {{ $questions[$i]->first_choice }}<br>
                       <input type="radio" required="true" name="choices[{{ $i  }}]" value="2"> {{ $questions[$i]->second_choice }}<br>
                       <input type="radio" required="true" name="choices[{{ $i  }}]" value="3"> {{ $questions[$i]->third_choice }}<br>
                       <input type="radio" required="true" name="choices[{{ $i  }}]" value="4"> {{ $questions[$i]->fourth_choice }}<br>
                       <input type="hidden" name="correct_choices[{{ $i  }}]" value="{{ $questions[$i]->correct_choice }}">
                       <input type="hidden" name="question_points[{{ $i  }}]" value="{{ $questions[$i]->question_points }}"> --}}
                   </div>
               </div>
               <br>
           @endfor
           <hr>
           <div class="row">
               <div class="col-md-6">
                   @if(Auth::User()->isStudent())
                       <button type="submit"  class="btn btn-primary" {{ Auth::User()->checkIfStudentSubmittedQuiz($quiz)? 'disabled': '' }}>Submit Answers</button>
                   @endif
                   @if(Auth::User()->checkIfStudentSubmittedQuiz($quiz))
                       <span class="text-success d-block mt-1"><i class="fas fa-info-circle mr-1"></i>This quiz has been already submitted</span>
                   @endif

               </div>
           </div>
       </form>
    </div>
         <div class="modal"><!-- Place at bottom of page --></div>
@endsection

@section('scripts')
    <script>
        $body = $("body");
        $(document).on({
            ajaxStart: function() { $body.addClass("loading"); },
            ajaxStop: function() { $body.removeClass("loading"); }
        });
    </script>
    @if(Auth::User()->isInstructor())
        <script>
            var quizID = {!! json_encode($quiz->id) !!};
        </script>
    @endif
    <script src="{{ asset('js/submitQuizForm.js') }}"></script>
@endsection
