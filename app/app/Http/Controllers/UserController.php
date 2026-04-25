<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Post;
use App\User;

class UserController extends Controller
{
    public function mypage()
    {
        $user = Auth::user();
        $posts = Post::where('user_id', $user->id)->where('status', 1)->latest()->get();
        return view('users.mypage', compact('user', 'posts'));
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        $posts = Post::where('user_id', $user->id)->where('status', 1)->latest()->get();

        return view('users.show', compact('user', 'posts'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('users.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'name' => 'required|max:50',
            'email' => 'required|email',
            'comment' => 'nullable|max:255',
            'image' => 'nullable|image|max:2048',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->comment = $request->comment;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('profiles', 'public');
            $user->image = $path;
        }

        $user->save();

        return redirect()->route('user.edit')->with('success', '更新しました');
    }

    public function index()
    {
        $user = Auth::user();

        $bookmarks = Bookmark::where('user_id', $user->id)
            ->with('post') 
            ->get();

        return view('bookmarks.index', compact('bookmarks'));
    }
    
    public function withdrawConfirm()
    {
        return view('users.withdraw_confirm');
    }
    public function withdraw()
    {
        $user = Auth::user();

        Auth::logout();

        $user->delete();

        return redirect('/login')->with('success', '退会しました');
    }
}