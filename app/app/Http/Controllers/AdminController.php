<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\User;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function top()
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403);
        }

        $ports = Post::with('user')->latest()->get();
        return view('admin.top');
    }

    public function usersIndex()
    {
        if(!Auth::check() || Auth::user()->role !== 'admin'){
            abort(403);
        }

        $users = User::withCount(['posts as stopped_posts_count' => function($query){
                $query->where('status', 0);
        }])->where('role', 'user')->orderBy('stopped_posts_count', 'desc')->get();
        return view('admin.users.index', compact('users'));
    }

    public function postsIndex()
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403);
        }

        $posts = Post::with('user')->withCount('reports')->orderBy('reports_count', 'desc')->take(20)->get();
        return view('admin.posts.index', compact('posts'));
    }

    public function hidePost(Post $post)
    {
        $post->status = 0;
        $post->save();

        return redirect()->route('admin.posts.index')->with('success', '投稿を非表示にしました');
    }

    public function showPost(Post $post)
    {
        $post->status = 1;
        $post->save();

        return redirect()->route('admin.posts.index')->with('success', '投稿を表示にしました');
    }

    public function toggleUserStatus(User $user)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin'){
            abort(403);
        }

        if ($user->role === 'admin') {
            return redirect()->route('admin.users.index')->with('error', '管理者は変更できません');
        }

        $user->status = $user->status == 1 ? 0 : 1;
        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'ユーザーの状態を更新しました');
    }

}
