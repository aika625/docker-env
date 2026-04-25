<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Bookmark;
use Illuminate\Support\Facades\Auth;

class BookmarkController extends Controller
{
    public function store($postId)
    {
        if (Auth::user()->status == 0) {
            return redirect()->back()->with('error', '利用停止中のため操作できません');
        }
        Bookmark::firstOrCreate([
            'user_id' => Auth::id(),
            'post_id' => $postId,
        ]);

        return back()->with('success', 'ブックマークしました');
    }

    public function destroy($postId)
    {
        Bookmark::where('user_id', Auth::id())
            ->where('post_id', $postId)
            ->delete();

        return back()->with('success', 'ブックマークを解除しました');
    }

    public function index()
    {
        $bookmarks = Bookmark::with('post')
            ->where('user_id', Auth::id())
            ->get();

            return view('bookmarks.index', compact('bookmarks'));
    }

}
