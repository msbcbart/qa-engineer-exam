<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function videos(Request $request)
    {
        return view('video')->with([
            'token' => $request->cookie('access_token')
        ]);
    }
}
