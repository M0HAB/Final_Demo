<!-- Sidebar  -->
<div id="sidebar" class="active">
    <ul class="list-unstyled components">
        <li class="">
            <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fas fa-users mr-2" style="font-size: 18px"></i> User</a>
            <ul class="collapse list-unstyled" id="homeSubmenu">
                <li>
                    <a href="#">Profile</a>
                </li>
                <li>
                    <a href="#courses" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Courses</a>
                    <ul class="collapse list-unstyled" id="courses">
                        <li><a href="{{ route('course.getNewCourseForm') }}"><i class="fas fa-plus mr-2"></i> Create New Course</a></li>
                        @foreach (Auth::user()->courses()->get() as $key => $course)
                        <li>
                            <a href="#{{ $course->id }}" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fas fa-minus mr-2"></i> {{ $course->title }}</a>
                            <ul class="collapse list-unstyled" id="{{ $course->id }}">
                                @if (Auth::user()->isInstructor())
                                    <li>
                                        <a href="{{ route('course.viewCourseModules', ['id' => $course->id]) }}" class="pl-4"><i class="fas fa-eye mr-2"></i> View</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('course.getUpdateCourseForm', ['id' => $course->id]) }}" class="pl-4"><i class="fas fa-edit mr-2"></i> Update Course Info.</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('course.getNewModuleForm', ['id' => $course->id]) }}" class="pl-4"><i class="fas fa-edit mr-2"></i> Add New Module</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('course.gradeBook.index', ['id' => $course->id]) }}" class="pl-4"><i class="fas fa-edit mr-2"></i> Grades Book Settings</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('course.studentGrades.index', ['id' => $course->id]) }}"><i class="fas fa-edit mr-2"></i> Students Grades</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('course.listUserCourses') }}"><i class="fas fa-list mr-2"></i> Courses Catalog</a>
                                    </li>
                                @elseif (Auth::user()->isStudent())
                                    <li>
                                        <a href="{{route('course.studentGrades.show', ['course' =>$course->id, 'student_id' => Auth::user()->id])}}" class="ml-1"><i class="fas fa-graduation-cap mr-"></i>My grades</a>
                                    </li>
                                @endif
                            </ul>
                        </li>
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