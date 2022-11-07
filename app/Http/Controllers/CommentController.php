<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Work;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Work $work, Comment $comment = null)
    {
        $data = request()->validate([
            'text' => ['required', 'string', 'max:500'],
        ]);

        $work->comments()->create(array_merge($data, [
            'user_id' => auth()->user()->id,
            'work_id' => $work->id,
            'comment-response_id' => is_null($comment) ? null : $comment->id
        ]));

        return redirect('/work/' . $work->id);
    }
}
