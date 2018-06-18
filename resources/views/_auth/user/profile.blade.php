@extends('_layouts.app')
@section('title', Auth::user()->fname)
@php
    $authUser = Auth::user();
@endphp
@section('content')
    <!-- Start: Profile -->
    <div class="row f-rw">
        {{--  User-Info  --}}
        <div class="col-lg-12 col-sm-12 mb-4">
            <h1 class="display-4">{{ $authUser->lname . ' ' . $authUser->lname }}</h1>
            <div class="bbp-breadcrumb pb-4">
                <p>
                    <a href="#" class="bbp-breadcrumb-home profile-a">Home</a> 
                    <span class="bbp-breadcrumb-sep">&rsaquo;</span> 
                    <span class="bbp-breadcrumb-current">{{ getEndPoint() }}</span>
                </p>
            </div>
                
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#info">Info.</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#roll-courses">Registered Courses</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Activities</a>
                    <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 39px, 0px); top: 0px; left: 0px; will-change: transform;">
                        <a class="dropdown-item" href="#assignment" data-toggle="tab">Assignment</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#quizzes" data-toggle="tab">Quizzes</a>
                    </div>
                </li>
            </ul>
            <div id="myTabContent" class="tab-content">
                <div class="tab-pane show active" id="info">
                    <table class="table">
                        <tbody>
                            <tr>
                                <th scope="row">Username</th>
                                <td>{{ $authUser->lname . ' ' . $authUser->lname }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Email</th>
                                <td>{{ $authUser->email }}</td>
                            </tr> 
                            <tr>
                                <th scope="row">Department</th>
                                <td>{{ $authUser->department->name }}</td>
                            </tr> 
                            <tr>
                                <th scope="row">Gender</th>
                                <td>{{ ($authUser->gender) ? 'Male' : 'Female' }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Role</th>
                                <td>{{ ($authUser->role_id) ? 'Instructor' : 'Student' }}</td>
                            </tr> 
                            <tr>
                                <th scope="row">Location</th>
                                <td>{{ $authUser->location }}</td>
                                </tr>
                            @if ($authUser->role_id != 1)
                                <tr>
                                    <th scope="row">Level</th>
                                    <td>{{ $authUser->level }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">GPA</th>
                                    <td>{{ $authUser->gpa }}</td>
                                </tr>
                            @endif
                        </tbody>
                    </table> 
                </div>
                <div class="tab-pane" id="roll-courses">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Course Name</th>
                                <th>Course Code</th>
                                <th>Credit Hour</th>                                             
                                <th rowspan="2">Prerequisites</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <p class="font-weight-bold text-success">Artificial Intelligence</p>
                                    <small>
                                        <p>Insrtuctor: <span class="font-weight-bold">Mohab</span></p>
                                        <p>Insrtuctor Assistant: <span class="font-weight-bold">Mohab</span></p>
                                    </small>
                                </td>
                                <td><span>Code-1</span></td>
                                <td><span>3</span></td>
                                <td>
                                    <p>Test</p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p class="font-weight-bold text-success">Computer Modelling And Simulation</p>
                                    <small>
                                        <p>Insrtuctor: <span class="font-weight-bold">Mohab</span></p>
                                        <p>Insrtuctor Assistant: <span class="font-weight-bold">Mohab</span></p>
                                    </small>
                                </td>
                                <td><span>Code-2</span></td>
                                <td><span>4</span></td>
                                <td><p>Test</p></td>
                            </tr>
                            <tr>
                                <td>
                                    <p class="font-weight-bold text-success">Digital Signal Processing</p>
                                    <small>
                                        <p>Insrtuctor: <span class="font-weight-bold">Mohab</span></p>
                                        <p>Insrtuctor Assistant: <span class="font-weight-bold">Mohab</span></p>
                                    </small>
                                </td>
                                <td><span>Code-3</span></td>
                                <td><span>3</span></td>
                                <td>
                                    <p>Test</p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p class="font-weight-bold text-success">Pattern Recognition</p>
                                    <small>
                                        <p>Insrtuctor: <span class="font-weight-bold">Mohab</span></p>
                                        <p>Insrtuctor Assistant: <span class="font-weight-bold">Mohab</span></p>
                                    </small>
                                </td>
                                <td><span>Code-4</span></td>
                                <td><span>3</span></td>
                                <td>
                                    <p>Test</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                {{--  Activities  --}}
                <div class="tab-pane" id="assignment">
                    <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Eveniet accusamus debitis nobis officiis aperiam blanditiis veniam dolores! Pariatur, nihil? Totam, dignissimos officiis. Saepe earum quaerat dolorum, facilis asperiores esse commodi.</p>
                </div>
                <div class="tab-pane" id="quizzes">
                    <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Provident, obcaecati at quod harum quas accusamus, esse quos quis incidunt, sit odit sint aliquid quia nesciunt necessitatibus ratione fuga ad odio?</p>
                </div>
            </div>
        </div>
    </div> <!-- End: Profile -->
@endsection