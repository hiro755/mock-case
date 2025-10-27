@extends('layouts.app')

@section('content')
<div class="text-center my-5">
    <h2>カード支払いの手続きが完了しました</h2>
    <p>商品：{{ $product->name }}<br>金額：¥{{ number_format($product->price) }}</p>

    <a href="{{ route('products.index') }}" class="btn btn-primary mt-4">商品一覧に戻る</a>
</div>
@endsection