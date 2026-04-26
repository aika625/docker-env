@extends('layouts.app')

@section('content')
<div class="container">
    <h1>ユーザー情報</h1>

    <form action="{{ route('user.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div>
            <label>ユーザー名</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}">
        </div>
            
        <div>
            <label>メールアドレス</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}">
        </div>

        <div>
            <label>コメント</label>
            <textarea name="comment">{{ old('comment', $user->comment) }}</textarea>
        </div>

        <div>
            @if($user->image)
                <img src="{{ asset('storage/' . $user->image) }}" width="100">
            @else
                <p>プロフィール画像は未登録です</p>
            @endif
        </div>

        <div>
            <input type="file" name="image">
        </div>

        <button type="submit">保存</button>

        <a href="/mypage">戻る</a>
    </form>

    <a href="{{ route('user.withdraw.confirm') }}">退会</a>
</div>
@endsection