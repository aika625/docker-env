@extends('layouts.app')

@section('content')
<div class="container">
    <h1>新規投稿</h1>
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul style="margin-bottom: 0;">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>

@endif

<form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="form-group">
        <label for="title">タイトル</label>
        <input
        type="text"
        name="title"
        id="title"
        class="form-control"
        value="{{ old('title') }}"
        >
    </div>

    <div class="form-group">
        <label for="address">留学地域</label>
        <input 
        type="text" 
        name="address" 
        id="address" 
        class="form-control"
        value="{{ old('address') }}">
    </div>

    <div class="form-group">
        <label for="image">画像</label>
        <input 
        type="file" 
        name="image" 
        id="image" 
        class="form-control"
        >
    </div>

    <div class="form-group">
        <label for="body">本文</label>
        <textarea
        name="body"
        id="body"
        class="form-control"
        rows="5">{{ old('body') }}</textarea>
    </div>
    <button type="submit" class="btn btn-success">投稿する</button>
    <a href="{{ route('posts.index') }}" class="btn btn-secondary">戻る</a>
</form>
</div>
@endsection