@extends('layouts.app')

@section('content')
<div class="container">
    <h1> ブックマーク一覧</h1>

    @foreach($bookmarks as $bookmark)
        <div>
            <h3>{{ $bookmark->post->title }}</h3>
            <a href="/posts/{{ $bookmark->post->id }}">詳細</a>
        </div>
    @endforeach

    @if($bookmarks->isEmpty())
        <p>ブックマークはまだありません</p>
    @else
        @foreach($bookmarks as $bookmark)
            <div>
                <a href="{{ route('posts.show', $bookmark->post->id) }}">
                    {{ $bookmark->post->title}}
                </a>
            </div>
        @endforeach
    @endif
    <a href="{{ route('posts.index') }}" class="btn btn-secondary">一覧へ戻る</a>
</div>
@endsection