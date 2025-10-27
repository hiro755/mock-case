@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="{{ asset('css/product.css') }}">

<div class="container mt-4 d-flex justify-content-center">
    <div class="row w-100">
        <div class="col-md-5 text-center">
            @php
                $imagePath = $product->image ?? $product->image_path;
            @endphp
            <img src="{{ $imagePath ? asset('storage/' . $imagePath) : 'https://via.placeholder.com/500x500?text=No+Image' }}"
                alt="商品画像" class="img-fluid border">
        </div>

        <div class="col-md-7">
            <h2 class="fw-bold">{{ $product->name }}</h2>
            <p class="text-muted">{{ $product->brand_name }}</p>
            <p class="fs-3 fw-bold">
                ¥{{ number_format($product->price) }}
                <span class="text-muted">（税込）</span>
            </p>

            <div class="d-flex align-items-start gap-4 mb-3">
                <div class="icon-stack text-center">
                    @auth
                        <form method="POST" action="{{ route('like.toggle', $product->id) }}">
                            @csrf
                            <button type="submit"
                                class="icon-button icon-like {{ $product->likes->where('user_id', auth()->id())->count() ? 'liked' : '' }}">
                                <i class="fa-regular fa-star"></i>
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="icon-button icon-like">
                            <i class="fa-regular fa-star"></i>
                        </a>
                    @endauth
                    <div class="icon-count">{{ $product->likes->count() }}</div>
                </div>

                <div class="icon-stack text-center">
                    <div class="icon-button icon-comment">
                        <i class="fa-regular fa-comment"></i>
                    </div>
                    <div class="icon-count">{{ $product->comments->count() }}</div>
                </div>
            </div>

            <a href="{{ route('purchase.address', ['item_id' => $product->id]) }}" class="btn btn-danger btn-lg w-100 mb-4">
                購入手続きへ
            </a>

            <h4>商品説明</h4>
            <p>カラー：{{ $product->color ?? 'ー' }}</p>
            <p>{{ $product->description }}</p>

            <h4>商品の情報</h4>
            <p class="mb-2">
                <span class="fw-bold me-2">カテゴリー</span>
                @foreach(explode(',', $product->category) as $cat)
                    <span class="badge bg-light border text-dark fw-normal">{{ $cat }}</span>
                @endforeach
            </p>
            <p>
                <span class="fw-bold" style="margin-right: 4rem;">商品の状態</span>
                <span>{{ $product->condition ?? 'ー' }}</span>
            </p>

            <h4 class="mt-4">コメント ({{ $product->comments->count() }})</h4>
            @foreach($product->comments as $comment)
                <div class="comment-wrapper mb-3">
                    <div class="d-flex align-items-center mb-1">
                        <img src="{{ $comment->user->icon ? asset('storage/' . $comment->user->icon) : asset('images/default-profile.png') }}"
                            alt="ユーザー画像" class="comment-avatar me-2">
                        <div class="fw-bold comment-username">{{ $comment->user->name }}</div>
                    </div>
                    <div class="comment-content-box">
                        {{ $comment->content }}
                    </div>
                </div>
            @endforeach

            <div class="comment-section mt-4">
                <h5 class="fw-bold mb-3">商品へのコメント</h5>

                @auth
                    <form method="POST" action="{{ route('comment.store', $product->id) }}">
                        @csrf
                        <div class="mb-3">
                            <textarea name="content" rows="4" class="form-control"></textarea>
                        </div>
                        <button type="submit" class="btn btn-danger w-100">コメントを送信する</button>
                    </form>
                @else
                    <form method="GET" action="{{ route('login') }}">
                        <div class="mb-3">
                            <textarea rows="4" class="form-control" disabled></textarea>
                        </div>
                        <button type="submit" class="btn btn-danger w-100">コメントを送信する</button>
                    </form>
                @endauth
            </div>
        </div>
    </div>
</div>

@endsection