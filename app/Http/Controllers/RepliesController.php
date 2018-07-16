<?php

namespace App\Http\Controllers;
use App\Thread;
use App\Http\Requests\RepliesRequest;
use Illuminate\Http\Request;

class RepliesController extends Controller
{
     public function __construct()
    {
        $this->middleware('auth');
    }

    public function store($channelId,Thread $thread,RepliesRequest $request)
    {
        $thread->addReply([
            'body'          => $request['body'],
            'user_id'       => auth()->id(),
        ]);

        return back()->with('flash','Your reply has been created');
    }
}
