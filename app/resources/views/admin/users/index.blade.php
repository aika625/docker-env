@extends('layouts.app')

@section('content')
<div class="container">
    <h1>一般ユーザー一覧</h1>
    

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>名前</th>
                <th>メール</th>
                <th>状態</th>
                <th>操作</th>
                <th>投稿非表示数</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>

                <td>
                    @if($user->status == 1)
                        <span class="badge badge-success">利用中</span>
                    @else
                        <span class="badge badge-warning">利用停止</span>
                    @endif
                </td>
                
                <td>
                    <form action="{{ route('admin.users.toggle', $user->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-sm {{ $user->status == 1 ? 'btn-warning' : 'btn-success' }}">
                            {{ $user->status == 1 ? '利用停止にする' : '利用再開にする' }}
                        </button>
                    </form>
                </td>
                <td>{{ $user->stopped_posts_count }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection