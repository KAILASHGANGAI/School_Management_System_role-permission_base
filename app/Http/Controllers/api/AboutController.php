<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\about;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;

class AboutController extends Controller
{
    public function index()
    {
        $data = about::all();

        return response()->json($data);
    }

    public function store(Request $req)
    {
        $new = new about();
        $new->heading = $req->heading;
        $new->subheading = $req->subheading;
        $new->description = $req->description;
        if ($req->image) {
            $position = strpos($req->image, ';');
            $sub = substr($req->image, 0, $position);
            $ext = explode('/', $sub)[1];
            $name = time().'.'.$ext;
            $img = Image::make($req->image)->resize(240, 240);
            $upload_path = 'images/about/';
            $image_url = $upload_path.$name;

            if ($img->save($image_url)) {
                $new->image = $image_url;
            }
        }
        if ($new->save()) {
            return response()->json([
                'status' => 'about added successfully',
            ]);
        } else {
            return response()->json([
                'status' => 'about Not added successfully',
            ]);
        }
    }

    public function edit($id)
    {
        $data = about::find($id);

        return response()->json($data);
    }

    public function update(Request $req, $id)
    {
        $update = about::find($id);
        $update->heading = $req->heading;
        $update->subheading = $req->subheading;
        $update->description = $req->description;
        if ($req->image != $update->image) {
            $position = strpos($req->image, ';');
            $sub = substr($req->image, 0, $position);
            $ext = explode('/', $sub)[1];
            $name = time().'.'.$ext;
            $img = Image::make($req->image)->resize(240, 240);
            $upload_path = 'images/about/';
            $image_url = $upload_path.$name;
            if (isset($update->image)) {
                unlink($update->image);
            }
            if ($img->save($image_url)) {
                $update->image = $image_url;
            }
        }
        if ($update->save()) {
            return response()->json([
                'status' => 'about updated successfully',
            ]);
        } else {
            return response()->json([
                'status' => 'about Not updated successfully',
            ]);
        }
    }

    public function delete($id)
    {
        $data = about::find($id);
        if (isset($data->image)) {
            unlink($data->image);

        }
        if ($data->delete()) {
            return response()->json([
                'status' => 'about deleted successfully',
            ]);
        } else {
            return response()->json([
                'status' => 'about not deleted',
            ]);
        }
    }
}
