@extends('layouts.app')

@section('content')
<div class="container text-center">
    <h1>退会確認</h1>

    <p>本当に退会しますか？</p>
    <p>退会すると登録情報が利用できなくなります。</p>

    <form action="{{ route('user.withdraw') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-danger">退会する</button>
    </form>

    <br>

    <a herf="{ route('user.edit') }}" class="btn btn-secondary">キャンセル</a>
</div>
@endsection