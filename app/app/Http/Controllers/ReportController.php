<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Report;
use App\Post;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function store(Request $request, $postId)
    {
        $post = Post::findOrFail($postId);

        $exists = Report::where('user_id', Auth::id())->where('post_id', $post->id)->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'この投稿はすでに報告済みです。');
        }

        Report::create([
            'user_id' => Auth::id(),
            'post_id' => $post->id,
            'reason' => $request->reason,
        ]);

        return redirect()->route('posts.show', $post->id)->with('success', '違反報告を送信しました。');
    }

    public function create($postId)
    {
        $post = Post::with('user')->findOrFail($postId);

        return view('reports.create', compact('post'));
    }
}
