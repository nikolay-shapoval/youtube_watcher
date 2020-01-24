<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Comment;

class CommentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Comment
     */
    public function store(Request $request)
    {
        $comment             = new Comment;
        $comment->type       = $request['params']['type'] ? $request['params']['type'] : 'comment';
        $comment->text       = $request['params']['text'];
        $comment->item_id    = $request['params']['item_id'];
        $comment->is_visible = $request['params']['is_visible'];
        $comment->save();

        return $comment;
    }
}
