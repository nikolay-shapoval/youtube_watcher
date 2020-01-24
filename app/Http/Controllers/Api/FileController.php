<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\File;
use App\Models\Channel;

class FileController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $attachment        = $request->attachment;
        $destinationPath   = 'uploads/';
        $original_filename = $attachment->getClientOriginalName();
        $type              = $attachment->getClientOriginalExtension();
        $path              = $attachment->store($destinationPath);

        $new_file                    = new File;
        $new_file->original_filename = $original_filename;
        $new_file->type              = $type;
        $new_file->path              = $path;
        $new_file->save();

        $channel          = Channel::find($request->channel_id);
        $channel->file_id = $new_file->id;
        $channel->save();

        return $channel;
    }

    public function download($id)
    {
        $path = File::find($id)->path;
        $file = response()->download(storage_path('app/' . $path));

        return $file;
    }
}
