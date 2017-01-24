<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;


class CuestionarioController extends Controller
{
    public function files(Request $request)
    {
        //$img = Image::make($request[0]['file']);

        //Storage::put('image.jpg', file_get_contents($request->files));
        dd($request);

    }
}
