@extends('_Auth.admin.admin_layout.admin')
@section('title', 'Courses List')


@section('admin_content')
    <div class="card">
        <div class="card-body position-relative">
            <h3 class="pb-2 mr-3 f-rw d-inline" >{{ $course->title }}</h3><Small class="text-muted font-weight-bold">Course Students</Small>
            <hr>
            @if(count($students) > 0)
                <input class="form-control" type="text" id="myInput" onkeyup="searchStudent()" placeholder="Search for studnt by NAME....">
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
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($students as $student)
                        <tr>
                            <td>{{ $student->fname }}</td>
                            <td>{{ $student->lname }}</td>
                            <td>{{ $student->email }}</td>
                            <td>{{ $student->gender? 'Male':'Female' }}</td>
                            <td>{{ $student->level }}</td>
                            <td>{{ $student->gpa }}</td>
                            <td>{{ $student->location}}</td>
                            <td>
                                <form action="{{ route('admin.course.unAssignStudent', ['course' => $course->id, 'assign' => $student->assignID]) }}" method="POST">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <button type="submit"  onclick="return ConfirmDelete()" class="btn btn-outline-primary">Un-assign</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @else
                <p><i class="fa fa-info-circle mr-1"></i> This course has no assigned students</p>
            @endif
        </div>
    </div>
@endsection

@section('scripts')



    <script>

        function ConfirmDelete(){
            return confirm('Are you sure you want to un-assign this student?');
        }

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

