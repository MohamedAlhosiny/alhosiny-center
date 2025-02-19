@extends('layouts.app')

@section('content')


<div class="container col-6 mt-5">
    <div class="card card-body ">
      <form action="{{route('drives.update' , $drive)}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
             <input type="text" value="{{$drive->title}}" name="title" id="title" class="form-control @error('title') is-invalid @enderror">
             @error('title')
             <div class="alert alert-danger">{{ $message }}</div>
         @enderror
        </div>
        <div class="mb-3">
            <label for="description" class="form-control">Description</label>
            <textarea name="description" id="description"  class="form-control">{{$drive->description}}</textarea>
            @error('description')
    <div class="alert alert-danger">{{ $message }}</div>
@enderror
        </div>

        <div class="mb-3">
            <label for="file" class="form-label">File</label>
            <a target="_blank" href="{{asset('drives/' . $drive->file_name)}}" >View File</a>
             <input type="file" name="file" id="file" class="form-control">
             @error('file')
             <div class="alert alert-danger">{{ $message }}</div>
         @enderror
        </div>
        <div class="text-center">
            <button class="btn btn-warning">Update File</button>
        </div>
      </form>

    </div>

</div>




@endsection
