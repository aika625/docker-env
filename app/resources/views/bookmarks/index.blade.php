@extends('layouts.app')

@section('content')
<div class="container">
    <h1> ブックマーク一覧</h1>

    @if($bookmarks->isEmpty())
        <p>ブックマークはまだありません</p>
    @else
        @foreach($bookmarks as $bookmark)
            @if($bookmark->post)
                <div class="card mb-3">
                    <div class="card-body">
                        <h3>{{ $bookmark->post->title}}</h3>
                        <a href="{{ route('posts.show', $bookmark->post->id) }}" class="btn btn-primary btn-sm">
                            詳細</a>
                    </div>
                </div>
            @endif
        @endforeach
    @endif
    <a href="{{ route('posts.index') }}" class="btn btn-secondary">一覧へ戻る</a>
</div>
@endsection