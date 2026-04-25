@extends('layouts.app')

@section('content')
<div class="container">
    <h1>マイページ</h1>

    <h3>プロフィール</h3>
    <p>ユーザー名：{{ $user->name }}</p>
    <p>メールアドレス：{{ $user->email }}</p>
    <div>
        <a href="{{ route('user.edit') }}">プロフィール編集・退会</a>
    </div>

    <div>
        <a href="{{ route('bookmarks.index') }}">ブックマーク一覧</a>
    </div>
    
    <hr>

    <h3>過去の投稿一覧</h3>

    @if($posts->isEmpty())
        <p>まだ投稿がありません。</p>
    @else
        @foreach($posts as $post)
            <div class="card mb-3">
                <div class="card-body">
                    <h5>{{ $post->title }}</h5>
                    <a href="{{ route('posts.show', $post->id) }}" class="btn btn-primary btn-sm">詳細を見る</a>
                </div>
            </div>
        @endforeach
    @endif
</div>
@endsection