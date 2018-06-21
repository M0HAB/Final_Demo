@extends('_Auth.admin.admin_layout.admin')
@section('title', $title)

@section('admin_content')


<div class="card">
  	<div class="card-body">
        <h3 class="f-rw">{{$title}}</h3>
        <table class="table">
            <tbody>
                @foreach($record->toArray() as $key => $val)
                    @if($val instanceof Illuminate\Database\Eloquent\Collection)
                        @if($val->count() > 0)
                            <tr>
                                <th rowspan="{{sizeof($val)}}" scope="row">{{$key}}</th>
                                @if($val[0]->trashed())
                                    <td>
                                        <a href="{{Storage::url($val[0]->filename)}}">{{array_values(array_slice(explode("/",$val[0]->filename), -1))[0]}}</a>
                                        <span class="badge badge-danger">Deleted</span>
                                    </td>
                                @else
                                    <td><a href="{{URL::to('/').$val[0]->filename}}">{{array_values(array_slice(explode("/",$val[0]->filename), -1))[0]}}</a></td>
                                @endif
                            </tr>
                            @foreach($val as $k => $value)
                                @if($k > 0)
                                    <tr>
                                        @if($value->trashed())
                                            <td>
                                                <a href="{{Storage::url($value->filename)}}">{{array_values(array_slice(explode("/",$value->filename), -1))[0]}}</a>
                                                <span class="badge badge-danger">Deleted</span>
                                            </td>
                                        @else
                                            <td><a href="{{URL::to('/').$value->filename}}">{{array_values(array_slice(explode("/",$value->filename), -1))[0]}}</a></td>
                                        @endif
                                    </tr>
                                @endif
                            @endforeach
                        @endif
                    @else
                        <tr>
                            <th scope="row">
                                @switch($key)
                                    @case('user_data')
                                        user
                                        @break
                                    @case('instructor_data')
                                        instructor
                                        @break
                                    @default
                                        {{$key}}
                                @endswitch
                            </th>
                            @if($key == "file")
                                <td><a href="{{URL::to('/').$val}}">{{array_values(array_slice(explode("/",$val), -1))[0]}}</a></td>
                            @else
                                <td style="word-break: break-all">{{($val)?:'Null'}}</td>
                            @endif
                        </tr>
                    @endif
                @endforeach

            </tbody>
        </table>


    </div>
</div>

@endsection
