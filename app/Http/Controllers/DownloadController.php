<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DownloadController extends Controller
{
    public function file($path)
    {
        if (! Storage::disk('local_storage')->exists($path)) {
            abort(404);
        }
        return Storage::disk('local_storage')->download($path);
    }
}
