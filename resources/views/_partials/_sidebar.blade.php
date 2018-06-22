<!-- Sidebar  -->
<div id="sidebar" class="active">
    <ul class="list-unstyled components">
        <li>
            <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="true" class="dropdown-toggle"><i class="fas fa-users mr-2" style="font-size: 18px"></i> {{ Auth::user()->fname . ' ' . Auth::user()->lname}}</a>
            <ul class="collapse list-unstyled show" id="homeSubmenu">
                <li>
                        <a href="{{ route('user.profile') }}"><i class="fas fa-user space-icon mr-2"></i> Profile</a>
                </li>
                <li>
                    <a href="#courses" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fas fa-cubes mr-2" style="font-size: 18px"></i> My Courses</a>
                    <ul class="collapse list-unstyled" id="courses">
                        @if (Auth::user()->isInstructor() && canCreate('Course'))
                            <li><a href="{{ route('course.getNewCourseForm') }}"><i class="fas fa-plus mr-2"></i> Create New Course</a></li>
                        @endif
                        @foreach (Auth::user()->courses()->get() as $key => $course)
                            @if(canRead('Course'))
                                <li>
                                    <a href="#{{ $course->id }}" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fas fa-minus mr-2"></i> {{ $course->title }}</a>
                                    <ul class="collapse list-unstyled" id="{{ $course->id }}">
                                        <li>
                                            <a href="{{ route('course.viewCourseModules', ['id' => $course->id]) }}" class=""><i class="fas fa-eye mx-2"></i> View</a>
                                        </li>
                                        @if(canRead('Discussion'))
                                            <li>
                                                <a href="{{ route('discussion.show', $course->discussion->id) }}"><i class="fas fa-graduation-cap  mx-2"></i> Discussion forum</a>
                                            </li>
                                        @endif
                                        @if (Auth::user()->isInstructor())
                                            @if(canUpdate('Course'))
                                                <li>
                                                    <a href="{{ route('course.getUpdateCourseForm', ['id' => $course->id]) }}" class="pl-4"><i class="fas fa-edit  mx-2"></i> Update Course Info.</a>
                                                </li>
                                            @endif
                                            @if(canCreate('Course'))
                                                <li>
                                                    <a href="{{ route('course.getNewModuleForm', ['id' => $course->id]) }}" class="pl-4"><i class="fas fa-edit  mx-2"></i> Add New Module</a>
                                                </li>
                                            @endif
                                            @if(canRead('Grade'))
                                                <li>
                                                    <a href="{{ route('course.gradeBook.index', ['id' => $course->id]) }}" class="pl-4"><i class="fas fa-edit  mx-2"></i> Grades Book Settings</a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('course.studentGrades.index', ['id' => $course->id]) }}"><i class="fas fa-edit  mx-2"></i> Students Grades</a>
                                                </li>
                                            @endif
                                        @elseif (Auth::user()->isStudent())
                                            @if(canRead('Grade'))
                                                <li>
                                                    <a href="{{route('course.studentGrades.show', ['course' =>$course->id, 'student_id' => Auth::user()->id])}}"><i class="fas fa-graduation-cap  mx-2"></i> My grades</a>
                                                </li>
                                            @endif
                                        @endif
                                    </ul>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </li>
            </ul>
        </li>
        {{--  <li>
            <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Pages</a>
            <ul class="collapse list-unstyled" id="pageSubmenu">
                <li>
                    <a href="#">Page 1</a>
                </li>
                <li>
                    <a href="#">Page 2</a>
                </li>
                <li>
                    <a href="#">Page 3</a>
                </li>
            </ul>
        </li>  --}}
    </ul>
</div>
