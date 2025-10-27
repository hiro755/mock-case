<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログイン | COACHTECH</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>
    <header class="navbar">
        <div class="navbar-container">
            <a href="{{ url('/') }}">
                <img src="{{ asset('storage/logo/logo.svg') }}" alt="COACHTECH ロゴ" class="navbar-logo">
            </a>
        </div>
    </header>

    <div class="container">
        <h2 class="title">ログイン</h2>

        <form method="POST" action="{{ route('login') }}" class="login-form">
            @csrf

            <div class="form-group">
    <label for="email">メールアドレス</label>
    <input type="email" id="email" name="email" value="{{ old('email') }}">
    @error('email')
        <div class="error">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="password">パスワード</label>
    <input type="password" id="password" name="password">
    @error('password')
        <div class="error">{{ $message }}</div>
    @enderror
</div>

            <button type="submit">ログインする</button>
        </form>

        <p class="register-link">
            <a href="{{ route('register') }}">会員登録はこちら</a>
        </p>
    </div>
</body>
</html>