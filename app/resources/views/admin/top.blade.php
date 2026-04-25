@extends('layouts.app')

@section('content')
<div class="container">
    <h1>管理者トップ</h1>

    <div class="mb-3">
        <a href="{{ route('admin.posts.index') }}" class="btn btn-primary">投稿一覧画面</a>
    </div>

    <div class="mb-3">
        <a href="{{ route('admin.users.index') }}" class="btn btn-primary">一般ユーザー一覧画面</a>
    </div>
</div>
@endsection