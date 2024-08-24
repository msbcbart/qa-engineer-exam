<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class VideoController extends Controller
{
    public function videos()
    {
        $urls = [];
        $files = File::allFiles(public_path('assets/videos'));

        foreach ($files as $file) {
            $relativePath = str_replace(public_path(), '', $file->getRealPath());
            $urls[] = $relativePath;
        }

        return response()->json([
            'videos' => $urls
        ]);
    }
}
