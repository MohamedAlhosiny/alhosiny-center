@extends('layouts.app')

@section('content')

<div class="container col-6 mt-5">
    <div class="card card-body table-responsive">
        @if (Session::has('success'))
        <div class="alert alert-success">
            {{Session::get('success')}}
        </div>
        @endif
        <h1 class="text-center">Public Files</h1>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>title</th>
                    <th>description</th>
                    <th>file type</th>
                    <th>Author</th>
                    <th>Actios</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($drives as $index => $drive  )


                <tr>
                    <td>{{$index + 1}}</td>
                    <td>{{$drive['title']}}</td>
                    <td>{{$drive->description}}</td>
                    <td>{{$drive->file_type}}</td>
                    <td>{{$drive->user->name}}</td>
                    @if($drive->user_id == auth()->id())
                    <td> <a href="{{route('drives.edit' , $drive->id)}}" class="btn btn-warning">Edit</a></td>
                    <td> <form action="{{route('drives.destroy' , $drive->id)}}" method="POST">
                        @csrf
                        @method('delete')
                       <button class="btn btn-danger">Delete</button> </td>
                       @endif
                       <td>
                        <a class="btn btn-success" href="{{route('drives.download' , $drive)}}">Download</a>
                       </td>


                    {{-- <td><a href="{{route('drives.destroy' , $drive->id)}}" class="btn btn-danger">Delete</a></td> --}}
                </form>
                </tr>
            </tbody>
            @empty
            <tr>
                <td colspan="6"><div class="alert alert-danger">There is no data</div></td>
            </tr>
            @endforelse
        </table>

    </div>

</div>
@endsection
