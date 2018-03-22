@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">Add New Post</div>

        <div class="card-body">

          <form method="post" action="{{ route('posts.store') }}">
            {{ csrf_field() }}
            <div class="form-group row">
              <label class="col-md-4 col-form-label text-md-right">Post Title</label>
              <input type="text" name="title">
            </div>
            <div class="form-group row">
              <label class="col-md-4 col-form-label text-md-right">Post Content</label>
              <textarea rows="5" cols="50" name="body"></textarea>
            </div>
            <div class="form-group row mb-0">
              <div class="col-md-8 offset-md-4">
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection