@extends('_Auth.admin.admin_layout.admin')
@section('title', $user->fname.' '.$user->lname)

@section('admin_content')

<div class="card">
  <div class="card-body">
      <div class="row f-rw">
          {{--  User-Info  --}}
          <div class="col-lg-12 col-sm-12 mb-4">
              <h3 class="f-rw">{{$user->fname.' '.$user->lname}}</h1>

              <ul class="nav nav-tabs">
                  <li class="nav-item">
                      <a class="nav-link active" data-toggle="tab" href="#info">Info.</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link" data-toggle="tab" href="#roll-courses">Courses</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link" data-toggle="tab" href="#roll-posts">User discussions</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link" data-toggle="tab" href="#roll-permissions">User permissions</a>
                  </li>

              </ul>
              <div id="myTabContent" class="tab-content">
                  <div class="tab-pane show active" id="info">
                      <table class="table">
                          <tbody>
                              <tr>
                                  <th scope="row">Name</th>
                                  <td>{{$user->fname.' '.$user->lname}}</td>
                              </tr>
                              <tr>
                                  <th scope="row">Email</th>
                                  <td>{{$user->email}}</td>
                              </tr>
                              <tr>
                                  <th scope="row">Department</th>
                                  <td>{{$user->department->name}}</td>
                              </tr>
                              <tr>
                                  <th scope="row">Gender</th>
                                  <td>{{($user->gender == 1)?'Male':'Female'}}</td>
                              </tr>
                              <tr>
                                  <th scope="row">Role</th>
                                  <td>{{$user->role->name}}</td>
                              </tr>
                              <tr>
                                  <th scope="row">Location</th>
                                  <td>{{$user->location}}</td>
                              </tr>
                              @if($user->isStudent())
                              <tr>
                                  <th scope="row">Level</th>
                                  <td>{{$user->level}}</td>
                              </tr>
                              <tr>
                                  <th scope="row">GPA</th>
                                  <td>{{$user->gpa}}</td>
                              </tr>
                              @endif

                          </tbody>
                      </table>
                  </div>
                  <div class="tab-pane" id="roll-courses" style="overflow-y:auto;max-height:400px">
                      <table class="table">
                          <thead>
                              <tr>
                                  <th>Course Name</th>
                                  <th>Course Code</th>
                                  <th>Credit Hour</th>
                              </tr>
                          </thead>
                          <tbody>
                              @if($user->isStudent())
                                  @foreach($user->studyCourses as $course)

                                  <tr>
                                      <td>
                                          <p class="font-weight-bold text-success">{{ucfirst($course->title)}}</p>
                                          <small>
                                              <p>Insrtuctor: <span class="font-weight-bold">{{$course->instructor->fname.' '.$course->instructor->lname}}</span></p>
                                          </small>
                                      </td>
                                      <td><span>{{$course->code}}</span></td>
                                      <td><span>{{$course->commitment}}</span></td>
                                  </tr>
                                  @endforeach
                              @else
                                  @foreach($user->courses as $course)

                                  <tr>
                                      <td>
                                          <p class="font-weight-bold text-success">{{ucfirst($course->title)}}</p>
                                          <small>
                                              <p>Insrtuctor: <span class="font-weight-bold">{{$course->instructor->fname.' '.$course->instructor->lname}}</span></p>
                                          </small>
                                      </td>
                                      <td><span>{{$course->code}}</span></td>
                                      <td><span>{{$course->commitment}}</span></td>
                                  </tr>
                                  @endforeach
                              @endif

                          </tbody>
                      </table>
                  </div>
                  <div class="tab-pane" id="roll-posts" style="overflow-y:auto;max-height:400px">
                      <table class="table">
                          <thead>
                              <tr>
                                  <th>Discussion_Course</th>
                                  <th>Id</th>
                                  <th>Type</th>
                                  <th>body</th>
                              </tr>
                          </thead>
                          <tbody>
                              @foreach($user->posts as $post)
                                  <tr>
                                      <td>
                                          <p class="font-weight-bold text-success">{{$post->discussion->course->title}}</p>
                                      </td>

                                      <td><p><span class="font-weight-bold">{{$post->id}}</span></p></td>
                                      <td>Post</td>
                                      <td><span>{{$post->body}}</span></td>
                                  </tr>
                              @endforeach
                              @foreach($user->replies as $reply)
                                  <tr>
                                      <td>
                                          <p class="font-weight-bold text-success">{{$reply->post->discussion->course->title}}</p>
                                      </td>

                                      <td><p><span class="font-weight-bold">{{$reply->id}}</span></p></td>
                                      <td>Reply</td>
                                      <td><span>{{$reply->body}}</span></td>
                                  </tr>
                              @endforeach
                              @foreach($user->comments as $comment)
                                  <tr>
                                      <td>
                                          <p class="font-weight-bold text-success">{{$comment->reply->post->discussion->course->title}}</p>
                                      </td>

                                      <td><p><span class="font-weight-bold">{{$comment->id}}</span></p></td>
                                      <td>Comment</td>
                                      <td><span>{{$comment->body}}</span></td>
                                  </tr>
                              @endforeach
                          </tbody>
                      </table>
                  </div>
                  <div class="tab-pane" id="roll-permissions">
                      @if($user->permission == null)
                           <p class="text-center mt-4 text-muted">Default Permissions for <strong><a href="{{route('prole.show', $user->role->id)}}">{{$user->role->name}}</a> | <a href="#">Edit here <i class="fas fa-edit"></i></a></strong></p>
                       @endif
                      <!-- <table class="table">
                          <tbody>
                              @if($user->permission == null)
                               <tr>
                                   <td>NoPERMISSION</td>
                               </tr>
                               @endif

                          </tbody>
                      </table> -->
                  </div>
              </div>
          </div>
      </div> <!-- End: Profile -->
  </div>
</div>

@endsection
