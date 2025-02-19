<?php

namespace App\Http\Controllers;

use App\Models\Drive;
use Illuminate\Http\Request;

class DriveController extends Controller
{
    public function __construct()
    {
       $this->middleware('auth')->except(['index' , 'create' , 'store']);

    }


    public function index()
    {
        $drives = Drive::with('user')->where('status' , 'public')->get();
        // return $drives;
        return view('drives.index')->with('drives', $drives);
    }

    public function myfiles(){
        $drives = Drive::where('user_id' , auth()->id())->get();
        // return $drives;
        return view('drives.myfiles' , compact('drives'));
    }


    public function changeStatus(Drive $drive){
        if($drive->status == 'private') {
            $drive->status = 'public';
        }else {
            $drive->status = 'private';
        }
        $drive->save();

        return redirect()->back()->with('success' , "$drive->title is changed to $drive->status");

    }

    public function download(Drive $drive){
        // return $drive;
        $full_path = public_path('drives/' . $drive->file_name);
        return response()->download($full_path);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('drives.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        // dd($request);
        $max_size = 5 * 1024;
        $request->validate([
            'title' => 'string|required|max:20|min:3',
            'description' => 'string|required|max:30',
            'file'=> "required|file|max:$max_size|mimes:png,pdf,jpeg,jpg"
        ]);
        $drive = new Drive();
        $drive->title = $request->title;
        $drive->description = $request->description;
        $file = $request->file('file');
        // dd($file);
        $file_name =   time() . "-" . $file ->getClientOriginalName();
        // return $file_name;
        $file_type = $file ->getClientMimeType();
        $file->move(public_path('drives/'), $file_name);
        $drive->file_name = $file_name;
        $drive->file_type = $file_type;
        $drive->user_id = auth()->id();

        $drive->save();

        return redirect()->route('drives.index')->with('success' , "data added successfully");



    }

    /**
     * Display the specified resource.
     */
    public function show(Drive $drive)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Drive $drive)
    {

        return view('drives.edit')->with('drive' , $drive);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Drive $drive)
    {


        $max_size = 5 * 1024;
        $request->validate([
            'title' => 'string|required|max:20|min:3',
            'description' => 'string|required|max:30',
            'file'=> "file|max:$max_size|mimes:png,pdf,jpeg,jpg"
        ]);

        $drive->title = $request->title;
        $drive->description = $request->description;
        $drive->update();
        $file = $request->file('file');
        if($file) {
            $path = public_path('drives/' . $drive->file_name);

        $file_name =   time() . "-" . $file ->getClientOriginalName();
        $file_type = $file ->getClientMimeType();
        $file->move(public_path('drives/'), $file_name);
        $drive->file_name = $file_name;
        $drive->file_type = $file_type;
        unlink($path);
        }


        $drive->save();


        return redirect()->route('drives.index')->with('success' , "file Updated Successfully");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Drive $drive)
    {
        //
        // return $drive;
        $path = public_path('drives/' . $drive->file_name);

        $drive->delete();
        unlink($path);

        return redirect()->back()->with('success' , "deleted successfully");
    }
}
