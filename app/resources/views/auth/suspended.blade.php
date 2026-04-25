@extends('layouts.app')

@section('content')
<div class="container text-center mt-5">
    <h1>アカウント停止中</h1>
    <p class="mt-4">このアカウントは現在利用停止されています。</p>

    <div class="mt-5">
        <a href="{{ route('login') }}" class="btn btn-primary">ログインに戻る</a>
    </div>
</div>
@endsection