@extends('layouts.app')

@section('content')
<div class="container">
    <h1>投稿編集</h1>

    @if($errors->any())
    <div class="alert alert-danger">
        <ul style="margin-bottom: 0;">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
 
    <form action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="title">タイトル</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $post->title) }}">
        </div>

        <div class="form-group">
        <label for="address">留学地域</label>
        <input type="text" name="address" id="address" class="form-control" value="{{ old('address', $post->address) }}">
        </div>

        <div class="form-group">
        <label for="image">画像</label>
        <input type="file" name="image" id="image" class="form-control" >
        </div>
        @if ($post->image)
            <div class="mt-2">
                <img src="{{ asset('storage/' . $post->image) }}" alt="投稿画像" width="200">
            </div>
        @endif

        <div class="form-group">
            <label>内容</label>
            <textarea name="body" id="body" class="form-control" rows="5">{{ old('body', $post->body) }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">更新する</button>
        <a href="{{ route('posts.index') }}" class="btn btn-secondary">戻る</a>
    </form>
</div>
@endsection