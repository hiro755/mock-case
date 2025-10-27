@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
<div class="register-container">
    <h2>会員登録</h2>
    <form action="{{ route('register') }}" method="POST">
        @csrf

        <div>
            <label for="name">ユーザー名</label>
            <input type="text" name="name" value="{{ old('name') }}">
            @error('name') <p class="error">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="email">メールアドレス</label>
            <input type="email" name="email" value="{{ old('email') }}">
            @error('email') <p class="error">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="password">パスワード</label>
            <input type="password" name="password">
            @error('password') <p class="error">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="password_confirmation">確認用パスワード</label>
            <input type="password" name="password_confirmation">
        </div>

        <button type="submit">登録する</button>

        <div class="login-link">
        <a href="{{ route('login') }}">ログインはこちら</a>
        </div>
    </form>
</div>
@endsection