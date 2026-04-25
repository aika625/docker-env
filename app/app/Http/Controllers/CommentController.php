<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;
use App\Post;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, $postId)
    {
        if (Auth::user()->status == 0) {
            return redirect()->back()->with('error', '利用停止中のためコメントできません');
        }
        $request->validate([
            'body' => 'required|max:255',
        ]);
        Comment::create([
            'user_id' => Auth::id(),
            'post_id' => $postId,
            'body' => $request->body,
        ]);

        return redirect()->route('posts.show', $postId);
    }
}
