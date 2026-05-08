@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">投稿一覧</h1>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
    <form action="{{ route('posts.index') }}" method="GET" class="mb-4">
        <div class="form-group mb-2">
            <input type="text" name="keyword" class="form-control" value="{{ old('keyword', $keyword ?? '') }}" placeholder="タイトル・内容・地域で検索">
        </div>
        <div class="form-group mb-2">
            <input type="date" name="start_date" value="{{ request('start_date') }}">
            <span>〜</span>
            <input type="date" name="end_date" value="{{ request('end_date') }}">
        </div>
        <button type="submit" class="btn btn-primary mt-2">検索</button>
    </form>
    </div>
    </div>

    <div style="margin-bottom: 20px;">
        <a href="{{ route('posts.create') }}" class="btn btn-primary">新規投稿</a>
    </div>

    @auth
        <a href="{{ route('bookmarks.index') }}" class="btn btn-primary mb-3">ブックマーク一覧</a>
    @endauth

    <div class="row">
        @foreach($posts as $post)
            <div class="col-md-6 mb-3">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <h5 class="card-title">{{ $post->title }}</h5>

                        <p class="card-text mt-3">{{ Str::limit($post->body, 80) }}</p>

                        <p class="text-muted mb-1">
                            投稿者：
                            <a href="{{ route('users.show', $post->user->id) }}" >{{ $post->user->name ?? '不明' }}</a>
                        </p>

                        @if ($post->image)
                            <img src="{{ asset('storage/' . $post->image) }}" class="img-fluid rounded mb-2">
                        @endif

                        <a href="{{ route('posts.show', $post->id) }}" class="btn btn-outline-primary btn-sm">詳細</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection