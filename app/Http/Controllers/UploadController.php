<?php

namespace App\Http\Controllers;

use App\Models\TemporaryFiles;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function store(Request $request)
    {

        if($request->hasFile('filepond')){
            $file = $request->file('filepond');
            $filename = $file->getClientOriginalName();
            $file->storeAs('filepma/tmp/', $filename);

            TemporaryFiles::create([
                'folder' => '',
                'filename' => $filename
            ]);

        }
    }
}
