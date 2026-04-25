@extends('layouts.app')

@section('content')
<div class="container">
    <h1>違反報告</h1>

    <p>投稿タイトル：{{ $post->title }}</p>
    <p>投稿者名：{{ $post->user->name }}</p>

    <form action="{{ route('reports.store', $post->id) }}" method="POSt">
        @csrf

        <div class="form-group">
            <label>違反報告理由</label>
            <select name="reason" class="form-control">
                <option value="">選択してください</option>
                <option value="不適切な内容">不適切な内容</option>
                <option value="迷惑行為">迷惑行為</option>
                <option value="スパム">スパム</option>
                <option value="その他">その他</option>
            </select>
        </div>

        <div class="form-group mt-3">
            <label>任意入力</label>
            <textarea name="detail" class="form-control" rows="4">{{ old('detail') }}</textarea>
        </div>

        <a href="{{ route('posts.show', $post->id )}}" class="btn btn-secondary mt-3">戻る</a>
        <button type="submit" class="btn btn-danger mt-3">送信</button>
    </form>
</div>
@endsection