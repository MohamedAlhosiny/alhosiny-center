<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Drive;
use Illuminate\Http\Request;
use Psy\Util\Str;

class DriveApiContoller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $drive = Drive::all();
        $response = [
            'message' => 'data retrieved successfully',
            'data' => $drive,
            'status code' => 200
        ];
        return response($response, 200);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $max_size = 5 * 1024 * 1024;
        $request->validate([
            'title' => 'string|required|max:20|min:3',
            'description' => 'string|required|max:30',
            'file' => "required|file|max:$max_size|mimes:png,pdf,jpeg,jpg"
        ]);

        $drive = new Drive();
        $drive->title = $request->title;
        $drive->description = $request->description;

        //file handling
        if ($request->hasFile('file')) {
            $file = $request->file('file');

            $file_name = time() . "-" . $file->getClientOriginalName();
            $file_type = $file->getClientMimeType();
            $file->move(public_path('drives/'), $file_name);
            $drive->file_name = $file_name;
            $drive->file_type = $file_type;
        }

        $drive->user_id = 1;
        $drive->save();

        $response = [
            'message' => 'data created successfully',
            'data' => $drive,
            'status' => 201 //created
        ];
        return response($response, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $drive = Drive::find($id);

        if (!empty($drive)) {
            $response = [
                'message' => 'data retrieved success',
                'data' => $drive,
                'status' => 200
            ];
        } else {
            $response = [
                'message' => 'no data to show',

                'status' => 404
            ];
        }



        return response($response, 200);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $drive = Drive::find($id);
        if(!empty($drive)){
            $max_size = 5 * 1024;  // = 5MB = 5120KB
            $request->validate([
                'title' => 'string|required|max:20|min:3',
                'description' => 'string|required|max:100',
                'file' => "file|max:$max_size|mimes:png,pdf,jpeg,jpg"
            ]);

            $drive->title = $request->title;
            $drive->title = $request->title;
            $drive->update();

            $file = $request->file('file');

            if ($file) {
                $path = public_path('drives/' . $drive->file_name);
                $file_name = time() . "-" .  $file->getClientOriginalName();
                $file_type = $file->getClientMimeType();
                $file->move(public_path('drives/'), $file_name);
                $drive->file_name = $file_name;
                $drive->file_type = $file_type;
                unlink($path);
            }

            $drive->save();

            $response = [
                'message' => 'data updated',
                'data' => $drive,
                'status' => 200
            ];



        }else {

            $response = [
                'message' => 'drive does not exist',
                'status' => 404
            ];
        }
        return response($response , 200);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {


        $drive = Drive::find($id);
        if (!empty($drive)) {
            $path = public_path('drives/' . $drive->file_name);
            $drive->delete();
            unlink($path);

            $response = [
                'message' => 'data deleted successfully',
                'data' => $drive,
                'status' => 204
            ];
        } else {
            $response = [
                'message' => 'no data',
                'status' => 400
            ];
        }


        return response($response, 200);
    }
}
