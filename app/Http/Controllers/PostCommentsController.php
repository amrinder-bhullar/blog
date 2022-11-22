<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

use function GuzzleHttp\Promise\all;

class PostCommentsController extends Controller
{
    public function store(Post $post)
    {
        //add a comment to given post
        // validation

        request()->validate([
            'body' => 'required'
        ]);

        $post->comments()->create([
            'user_id' => request()->user()->id,
            'body' => request('body')
        ]);

        return back();
    }
}
