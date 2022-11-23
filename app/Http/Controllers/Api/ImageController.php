<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Image;

class ImageController extends Controller
{
    public function destroy($id)
    {
    	if (Image::findOrFail($id)->delete()) {
            return response()->json([
            'status' => 201,
            ]);
        }
    }
}
