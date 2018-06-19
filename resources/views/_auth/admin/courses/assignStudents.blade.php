@extends('_Auth.admin.admin_layout.admin')
@section('title', 'Courses List')


@section('admin_content')
    <div class="card">
        <div class="card-body position-relative">
            <h3 class="pb-2 mr-3 f-rw d-inline" >{{ $course->title }}</h3><Small class="text-muted font-weight-bold">Assign Students</Small>
            <hr>
            <h4 class="mb-3">Select Students to be assigned with the course</h4>
            <input class="form-control" type="text" id="myInput" onkeyup="searchStudent()" placeholder="Search for studnt by NAME....">
            <form action="{{ route('admin.course.submitAssignStudents', ['course' => $course->id]) }}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <table class="table table-bordered text-center table-responsive mt-3" id="myTable">
                    <thead>
                    <tr>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Gender</th>
                        <th>Level</th>
                        <th>GPA</th>
                        <th>Location</th>
                        <th>Check To assign</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($students as $student)
                        @if(!($student->checkIfStudentAssignedToCourse($course->id)))
                            <tr>
                                <td>{{ $student->fname }}</td>
                                <td>{{ $student->lname }}</td>
                                <td>{{ $student->email }}</td>
                                <td>{{ $student->gender? 'Male':'Female' }}</td>
                                <td>{{ $student->level }}</td>
                                <td>{{ $student->gpa }}</td>
                                <td>{{ $student->location}}</td>
                                <td>
                                    <input type="checkbox"  name="students[]" value="{{ $student->id }}">
                                </td>
                            </tr>
                        @endif
                    @endforeach
                    </tbody>
                </table>
                <p class="text-right">
                    <button type="submit" class="btn btn-primary">Assign Students</button>
                </p>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function searchStudent() {
            // Declare variables
            var input, filter, table, tr, td, i;
            input = document.getElementById("myInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("myTable");
            tr = table.getElementsByTagName("tr");

            // Loop through all table rows, and hide those who don't match the search query
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[0];
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

