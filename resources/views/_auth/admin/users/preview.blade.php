@extends('_Auth.admin.admin_layout.admin')
@section('title', 'Users Messages')

@section('admin_content')


<div class="card">
  	<div class="card-body">
        <h3 class="f-rw">{{$title}}</h3>
        <table class="table">
            <tbody>
                @foreach($record->toArray() as $key => $val)
                    @if($val instanceof Illuminate\Database\Eloquent\Collection)
                        <tr>
                            <th rowspan="{{sizeof($val)}}" scope="row">{{$key}}</th>
                            <td><a href="{{URL::to('/').$val[0]->filename}}">{{array_values(array_slice(explode("/",$val[0]->filename), -1))[0]}}</a></td>
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
                    @else
                        <tr>
                            <th scope="row">{{$key}}</th>
                            <td>{{($val)?:'Null'}}</td>
                        </tr>
                    @endif
                @endforeach

            </tbody>
        </table>


    </div>
</div>

@endsection
