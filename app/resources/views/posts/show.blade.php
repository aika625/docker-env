@extends('layouts.app')

@section('content')
<div class="container">
    <h1>投稿詳細</h1>

    <div class="card shadow-sm">
        <div class="card-body">
            <h2 class="mb-3">{{ $post->title }}</h2>

            <a href="{{ route('users.show', $post->user->id) }}"><strong>投稿者：</strong>{{ $post->user->name ?? '不明' }}</a>
            <p><strong>留学地域：</strong>{{ $post->address }}</p>
            <p><strong>投稿日：</strong>{{ $post->created_at->format('Y/m/d') }}</p>

            <p><strong>内容：</strong></p>
            <p>{!! nl2br(e($post->body)) !!}</p>

            @if($post->image)
                <div class="mb-3">
                    <p><strong>画像：</strong></p>
                    <img src="{{ asset('storage/' . $post->image) }}" alt="投稿画像" class="img-fluid">
                </div>
            @endif

            <div style="margin-top: 20px;">
                <a href="{{ route('posts.index') }}" class="btn btn-secondary">一覧へ戻る</a>
                @if(Auth::id() === $post->user_id)
                    <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-primary">編集</a>

                    <form action="{{ route('posts.destroy', $post->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('削除しますか？')">削除</button>
                    </form>
                @else
                    <a href="{{ route('reports.create', $post->id) }}" class="btn btn-warning">違反報告</a>
                @endif

                @if(Auth::check())
                    @php
                        $isBookmarked = Auth::user()->bookmarkPosts->contains($post->id);
                    @endphp

                    <button id="bookmark-button" class="btn {{ $isBookmarked ? 'btn-warning' : 'btn-outline-warning' }}"
                    data-bookmarked="{{ $isBookmarked ? '1' : '0' }}"
                    data-store-url="{{ route('bookmarks.store', $post->id) }}"
                    data-destroy-url="{{ route('bookmarks.destroy', $post->id) }}">
                    {{ $isBookmarked ? 'ブックマーク解除' : 'ブックマーク' }}
                    </button>

                    <p id="bookmark-message" class="mt-2"></p>
                @endif
            </div>
            
            <hr class="my-4">

            <h4>コメント投稿</h4>
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form id="comment-form" action="{{ route('comments.store', $post->id) }}" method="POST">
                @csrf
                <div class="form-group">
                    <textarea name="body" id="comment-body" class="form-control" rows="4">{{ old('body') }}</textarea>
                </div>
                <button type="submit" class="btn btn-primary mt-2">コメントする</button>
            </form>

            <h4 class="mt-4 mt-3">コメント一覧</h4>

            <div id="comment-list">
            @forelse($post->comments as $comment)
                <div class="card mb-3 shadow-sm">
                    <div class="card-body">
                        <p class="mb-1">
                            <strong>{{ $comment->user->name ?? '不明' }}</strong>
                            <span class="text-muted small">
                                / {{ $comment->created_at->format('Y-m-d') }}
                            </span>
                        </p>
                        <p class="mt-2 mb-0">
                            {!! nl2br(e($comment->body)) !!}
                        </p>
                    </div>
                </div>
            @empty
                <p>まだコメントはありません</p>
            @endforelse
            </div>

        </div>
    </div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const button = document.getElementById('bookmark-button');

    if (!button) {
        return;
    }

    button.addEventListener('click', function () {
        const isBookmarked = button.dataset.bookmarked === '1';
        const url = isBookmarked ? button.dataset.destroyUrl : button.dataset.storeUrl;
        const method = isBookmarked ? 'DELETE' : 'POST';

        fetch(url, {
            method: method,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.bookmarked === true) {
                button.textContent = 'ブックマーク解除';
                button.className = 'btn btn-warning';
                button.dataset.bookmarked = '1';
            } else {
                button.textContent = 'ブックマーク';
                button.className = 'btn btn-outline-warning';
                button.dataset.bookmarked = '0';
            }

            document.getElementById('bookmark-message').textContent = data.message;
        })
        .catch(error => {
            document.getElementById('bookmark-message').textContent = '処理に失敗しました';
        });
    });
});
document.getElementById('comment-form').addEventListener('submit', function(e) {
    e.preventDefault();

    const body = document.getElementById('comment-body').value;
    const token = document.querySelector('input[name="_token"]').value;

    fetch(this.action, {
        method:'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token,
        },
        body: JSON.stringify({ body:body })
    })
    .then(response => response.json())
    .then(data => {
        const commentHTML = `
        <div class="card mb-3 shadow-sm">
            <div class="card-body">
                <p class="mb-1">
                    <strong>${data.user_name}</strong>
                    <span class="text-muted small">
                        / ${data.created_at}
                    </span>
                </p>
                <p class="mt-2 mb-0">${data.body}</p>
            </div>
        </div>
        `;

        document.getElementById('comment-list').insertAdjacentHTML('afterbegin', commentHTML);

        document.getElementById('comment-body').value = '';
    });
});
</script>
</div>
@endsection

