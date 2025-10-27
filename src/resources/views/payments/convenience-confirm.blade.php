@extends('layouts.app')

@section('content')
<div class="text-center my-5">
    <h2>コンビニ支払い確認</h2>
    <p>以下の内容で支払いを確定しますか？</p>

    <p>商品名：{{ $product->name }}</p>
    <p>価格：¥{{ number_format($product->price) }}</p>

    <form method="POST" action="{{ route('payment.convenience') }}">
        @csrf
        <input type="hidden" name="item_id" value="{{ $product->id }}">
        <button type="submit" class="btn btn-primary">支払いを完了する</button>
    </form>
</div>
@endsection