@extends('_Auth.admin.admin_layout.admin')
@section('title', 'Users Messages')

@section('admin_content')


<div class="card">
  	<div class="card-body">
        @include('_partials.errors')
        <form action="{{ route('admin.contact.store') }}" method="POST" role="form" autocomplete="off">
            {{ csrf_field() }}
            <div class="form-group">
            <label for="subject">Message Subject:</label>
            <input type="text" class="form-control" id="subject"
                placeholder="Enter message subject" name="subject" value="{{ old('subject', '') }}" required>
            </div>
            <div class="form-group">
                <label for="message">Message</label>
                <textarea class="form-control" id="message" rows="3" name="message"  placeholder="Enter Message here.." required>{{ old('message', '') }}</textarea>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>

@endsection
