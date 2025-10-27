@extends('layouts.app')

@section('content')
<div class="verify-wrap">
    <p class="verify-message">
        登録していただいたメールアドレスに認証メールを送信しました。<br>
        メール認証を完了してください。
    </p>

    @if (session('status') == 'verification-link-sent')
        <div class="verify-status">
            確認リンクがメールアドレスに再送信されました。
        </div>
    @endif

    <a href="http://localhost:8025" target="_blank" class="verify-button">
        認証はこちらから
    </a>

    <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <a href="{{ route('verification.send') }}" class="verify-resend"
        onclick="event.preventDefault(); this.closest('form').submit();">
            認証メールを再送する
        </a>
    </form>
</div>
@endsection