@extends('_Auth.admin.admin_layout.admin')
@section('title', 'Courses List')


@section('admin_content')
    <div class="card">
        <div class="card-body position-relative">
            <h3 class="pb-2 mr-3 f-rw " >Courses List</h3>
            <input class="form-control" type="text" id="myInput" onkeyup="searchCourse()" placeholder="Search for course by CODE....">

                <table class="table table-bordered table-responsive mt-3" id="myTable">
                    <thead>
                    <tr>
                        <th>Title</th>
                        <th>Code</th>
                        <th>Department</th>
                        <th>Specialization</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($courses as $course)
                            <tr>
                                <td>{{ $course->title }}</td>
                                <td>{{ $course->code }}</td>
                                <td>{{ $course->dep_name }}</td>
                                <td>{{ $course->spec_name }}</td>
                                <td><span class="badge {{ $course->is_active? 'badge-success':'badge-danger' }}">{{ $course->is_active? 'active':'Not active' }}</span></td>
                                <td>
                                    <div class="dropdown show">
                                        <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Select Action
                                        </a>

                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                            <a class="dropdown-item" href="{{ route('admin.course.assignStudents', ['course' => $course->id]) }}">Assign students</a>
                                            <a class="dropdown-item" href="{{ route('admin.course.courseStudents', ['course' => $course->id]) }}">List course students</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>


        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function searchCourse() {
            // Declare variables
            var input, filter, table, tr, td, i;
            input = document.getElementById("myInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("myTable");
            tr = table.getElementsByTagName("tr");

            // Loop through all table rows, and hide those who don't match the search query
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[1];
                if (td) {
                    if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }
    </script>
@endsection

