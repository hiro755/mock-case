@extends('layouts.app')

@section('content')
<div class="text-center my-5">
    <h2>コンビニ支払いの手続きが完了しました</h2>
    <p>決済が正常に完了しました。ご利用ありがとうございました。</p>

    <p>商品名：{{ $product->name }}</p>
    <p>価格：{{ number_format($product->price) }}円</p>

    <a href="{{ route('products.index') }}" class="btn btn-primary mt-4">商品一覧に戻る</a>
</div>
@endsection