@extends('_layouts.app')

@section('title')
    Add New Course
@endsection

@section('content')
    <div class="content mt-5 mb-5">
        <div class="container">
            <div id="response-message-success" class="alert alert-success" style="display: none"></div>
            <fieldset>
                <div class="reg-log-form p-3 my-3">
                    <legend><i class="fa fa-plus"></i> Add New Course</legend>
                    <hr>
                    <form id="submit-new-course">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="inputTitle">Course Title</label>
                                    <input type="text" name="title" class="form-control" id="inputTitle" value="{{ Request::old('title')? : '' }}"  placeholder="Enter the course title">
                                </div>
                                <div class="form-group">
                                    <label for="inputCode">Course Code</label>
                                    <input type="text" name="code" class="form-control" id="inputCode" value="{{ Request::old('code')? : '' }}"  placeholder="Enter the course code">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="inputStartDate">Start Date</label>
                                    <input type="date" name="start_date" class="form-control" id="inputStartDate" value="{{ Request::old('start_date')? : '' }}"  placeholder="Enter the course start date">
                                </div>
                                <div class="form-group">
                                    <label for="inputEndDate">End Date</label>
                                    <input type="date" name="end_date" class="form-control" id="inputEndDate" value="{{ Request::old('end_date')? : '' }}"  placeholder="Enter the course end date">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="inputCourseSpecialization">Course Specialization</label>
                                    <select name="course_specialization" class="form-control" id="inputCourseSpecialization" value="{{ Request::old('gender')? : '' }}"  data-placeholder="Select the specialization" style="width: 100%">
                                        <option value="">Select....</option>
                                        <option value="Computer Science">Computer Science</option>
                                        <option value="Data Science">Data Science</option>
                                        <option value="Embedded System">Embedded System</option>
                                        <option value="Communication">Communication</option>
                                        <option value="Electronics">Electronics</option>
                                        <option value="Basic Science">Basic Science</option>
                                    </select>
                                </div>
                            </div>


                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="inputCourseLanguage">Course Language</label>
                                    <select name="course_language" class="form-control" id="inputCourseLanguage"  data-placeholder="Select the language" style="width: 100%">
                                        <option value="">Select....</option>
                                        <option value="English">English</option>
                                        <option value="Arabic">Arabic</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="inputCourseDepartment">Course Department</label>
                                    <select name="course_department" class="form-control" id="inputCourseDepartment"   style="width: 100%">
                                        <option value="">Select....</option>
                                        <option value="Computer Department">Computer Department</option>
                                        <option value="Communication Department">Communication Department</option>
                                        <option value="Architecture Department">Architecture Department</option>
                                        <option value="Mechanical Department">Mechanical Department</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="inputCommitment">Course Commitment</label>
                                    <select name="commitment" class="form-control" id="inputCommitment"   style="width: 100%">
                                        <option value="">Select....</option>
                                        <option value=1>1</option>
                                        <option value=2>2</option>
                                        <option value=3>3</option>
                                        <option value=4>4</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group}}">
                                    <label for="inputCourseDescription">Course Description</label>
                                    <textarea name="description" class="form-control" id="inputCourseDescription"  placeholder="Enter the course description"></textarea>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="inputHowToPass">How To Pass The Course</label>
                                    <textarea name="how_to_pass" class="form-control" id="inputHowToPass"  placeholder="How student pass this course?"></textarea>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <br>
                                <button  class="btn btn-primary">Create New Course</button>
                            </div>
                        </div>
                    </form>
                </div>
            </fieldset>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/newCourseForm.js') }}"></script>
@endsection