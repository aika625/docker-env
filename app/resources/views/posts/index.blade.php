@extends('layouts.app')

@section('content')
<div class="container">
    <h1>投稿一覧</h1>

    <form action="{{ route('posts.index') }}" method="GET" class="mb-4">
        <div class="form-group mb-2">
            <input type="text" name="keyword" class="form-control" value="{{ old('keyword', $keyword ?? '') }}" placeholder="タイトル・内容・地域で検索">
        </div>
        <div class="form-group mb-2">
            <input type="date" name="start_date" class="form-control" value="{{ $start_date ?? '' }}">
        </div>
        <button type="submit" class="btn btn-primary mt-2">検索</button>
    </form>

    <div style="margin-bottom: 20px;">
        <a href="{{ route('posts.create') }}" class="btn btn-primary">新規投稿</a>
    </div>

    @auth
        <a href="{{ route('bookmarks.index') }}">ブックマーク一覧</a>
    @endauth

    @foreach($posts as $post)
    <div class="card mb-3">
        <div class="card-body">
            <h3>{{ $post->title }}</h3>
            <p>{{ $post->body }}</p>
            <a href="{{ route('users.show', $post->user->id) }}">投稿者：{{ $post->user->name ?? '不明' }}</a>
            @if ($post->image)
            <img src="{{ asset('storage/' . $post->image) }}">
            @endif
            <a href="{{ route('posts.show', $post->id) }}" class="btn btn-info">詳細</a>            

            @if(Auth::id() === $post->user_id)
            <a href="{{ route('posts.edit', $post->id)}}" class="btn btn-success btn-sm">編集</a>
            <form action="{{ route('posts.destroy', $post->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('削除してもよろしいですか？')">削除</button>
            </form>
            @endif
        </div>
    </div>
    @endforeach
</div>
@endsection