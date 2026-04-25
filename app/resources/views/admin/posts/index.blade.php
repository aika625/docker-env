@extends('layouts.app')

@section('content')
<div class="container">
    <h1>管理者 投稿一覧</h1>
    
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>投稿者</th>
                <th>タイトル</th>
                <th>投稿日</th>
                <th>状態</th>
                <th></th>
                <th>違反報告数</th>
            </tr>
        </thead>
        <tbody>
            @foreach($posts as $post)
            <tr>
                <td>{{ $post->id }}</td>
                <td>{{ $post->user->name ?? '不明' }}</td>
                <td>{{ $post->title }}</td>
                <td>{{ $post->created_at }}</td>
                <td>
                    @if($post->status == 1)
                        表示中
                    @else
                        非表示
                    @endif
                </td> 
                <td>
                    @if($post->status == 1)
                        <form action="{{ route('admin.posts.hide', $post->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-warning btn-sm">非表示</button>
                        </form>
                    @else
                        <form action="{{ route('admin.posts.show', $post->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success btn-sm">表示</button>
                        </form>
                    @endif
                </td>
                <td>{{ $post->reports_count }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection