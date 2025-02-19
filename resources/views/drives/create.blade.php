
@extends('layouts.app')

@section('content')

<div class="container col-6 mt-5">
    <div class="card card-body ">
      <form action="{{route('drives.store')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
             <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror">
             @error('title')
             <div class="alert alert-danger">{{ $message }}</div>
         @enderror
        </div>
        <div class="mb-3">
            <label for="description" class="form-control">Description</label>
            <textarea name="description" id="description"  class="form-control"></textarea>
            @error('description')
    <div class="alert alert-danger">{{ $message }}</div>
@enderror
        </div>

        <div class="mb-3">
            <label for="file" class="form-label">File</label>
             <input type="file" name="file" id="file" class="form-control">
             @error('file')
             <div class="alert alert-danger">{{ $message }}</div>
         @enderror
        </div>
        <div class="text-center">
            <button class="btn btn-primary">Submit File</button>
        </div>
      </form>

    </div>

</div>
@endsection
