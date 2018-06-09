<?php
namespace App\Http\Controllers\Quizes;

use App\Course;
use App\Http\Controllers\Controller;
use App\Module;
use App\Question;
use App\Quiz;
use App\QuizDeliver;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class Quizes_CRUD_Controller extends Controller{

    public function __construct(){
        $this->middleware(['auth', 'revalidate']);
    }



    public function getSubmitQuizForm(Course $course, Module $module, Quiz $quiz){

        if(Auth::User()->checkIfUserEnrolled($course->id)){
            $questions = DB::table('questions')
                ->leftjoin('quizzes', 'quizzes.id', '=', 'questions.quiz_id')
                ->where('questions.quiz_id', '=', $quiz->id)
                ->select('questions.*')
                ->get();
            return view('quizzes.submitQuizForm', compact('quiz', 'questions', 'module', 'course'));
        }else{
            return redirect()->back()->with('error', 'Unauthorized access');
        }
    }

    public function submitQuizAnswer(Request $request, Course $course, Module $module, Quiz $quiz){

        $student_grade = 0;
        foreach($request->choices as $key => $value){
           $correct_choice = $request->correct_choices[$key];
           if($value == $correct_choice){
               $student_grade = $student_grade + $request->question_points[$key];
           }
        }
        $quizDeliver = QuizDeliver::create([
            'user_id' => Auth::User()->id,
            'quiz_id' => $quiz->id,
            'grade' => $student_grade
        ]);

        if($quizDeliver){
            return redirect()->back()->with('success', 'Your answers has been submitted successfully');
        }
    }


    public function getNewQuizForm(Course $course, Module $module){

        if(Auth::User()->checkIfUserTeachCourse($course->id)){
            return view('Quizzes.newQuizForm', compact('course', 'module'));
        }
    }

    public function addNewQuiz(Request $request, Course $course, Module $module){

        $error_messages = [
            'questions.*.required' => 'please fill all the question fields',
            'first_choices.*.required' => 'please fill all the choices fields',
            'second_choices.*.required' => 'please fill all the choices fields',
            'third_choices.*.required' => 'please fill all the choices fields',
            'fourth_choices.*.required' => 'please fill all the choices fields',
            'question_points.*.required' => 'please fill all the question point fields',
            'correct_choices.*.required' => 'please fill all the correct choice fields'
        ];

        $validator = Validator::make($request->all(), [

            'title' => 'required',
            'deadline' => 'required',
            'questions.*' => 'required',
            'first_choices.*' => 'required',
            'second_choices.*' => 'required',
            'third_choices.*' => 'required',
            'fourth_choices.*' => 'required',
            'correct_choices.*' => 'required',
            'question_points.*' => 'required|numeric',

        ], $error_messages);
        if (!($validator->passes())) {
            return response($validator->errors(), 401);
        }

        $quiz = Quiz::create([
            'title' => $request->title,
            'deadline' => $request->deadline,
            'module_id' => $module->id,
            'total_grade' => $request->total_grade

        ]);
        $inserted_questions = 0;
        if($quiz){
            foreach($request->questions as $key => $val){
                $data = array(
                    'question' => $val,
                    'first_choice' => $request->first_choices[$key],
                    'second_choice' => $request->second_choices[$key],
                    'third_choice' => $request->third_choices[$key],
                    'fourth_choice' => $request->fourth_choices[$key],
                    'correct_choice' => $request->correct_choices[$key],
                    'question_points' => $request->question_points[$key],
                    'quiz_id' => $quiz->id
                );
                $question = Question::insert($data);
                if($question){
                    $inserted_questions ++;
                }
            }
            if($inserted_questions == count($request->questions)){
                return response()->json([
                    'message' => 'The quiz has been created successfully',
                ]);
            }
        }
    }

}