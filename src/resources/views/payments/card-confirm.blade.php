@extends('layouts.app')

@section('content')
<div class="text-center my-5">
    <h2>カード支払いの手続きが完了していません</h2>
    <p>決済を完了するには、以下のボタンを押してください。</p>

    <form method="POST" action="{{ route('payment.card') }}">
        @csrf
        <input type="hidden" name="item_id" value="{{ $product->id }}">
        <button type="submit" class="btn btn-primary mt-3">支払いを完了する</button>
    </form>
</div>
@endsection