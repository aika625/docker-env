<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Bookmark;
use Illuminate\Support\Facades\Auth;

class BookmarkController extends Controller
{
    public function store(Request $request, $postId)
    {
        if (Auth::user()->status == 0) {
            if ($request->ajax()){
                return response()->json(['message' => '利用停止中のため操作できません'], 403);
            }
            return redirect()->back()->with('error', '利用停止中のため操作できません');
        }

        Bookmark::firstOrCreate([
            'user_id' => Auth::id(),
            'post_id' => $postId,
        ]);

        if ($request->ajax()) {
            return response()->json([
                'bookmarked' =>true,
                'message' => 'ブックマークしました'
            ]);
        }

        return back()->with('success', 'ブックマークしました');
    }

    public function destroy(Request $request, $postId)
    {
        Bookmark::where('user_id', Auth::id())
            ->where('post_id', $postId)
            ->delete();

        if($request->ajax()) {
            return response()->json([
                'bookmarked' => false,
                'message' => 'ブックマークを解除しました'
            ]);
        }

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
