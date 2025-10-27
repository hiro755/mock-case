@section('content')
<div class="container">
    <h4 class="fw-bold mb-3">マイリスト</h4>

    <div class="row row-cols-2 row-cols-md-4 g-4">
        @forelse ($products as $product)
            <div class="col">
                <div class="card h-100">
                    <a href="{{ route('item.show', ['id' => $product->id]) }}">
                        <img
                            src="{{ asset('storage/' . ($product->image ?? $product->image_path)) }}"
                            class="card-img-top"
                            alt="商品画像"
                            onerror="this.src='https://via.placeholder.com/300x300?text=No+Image';"
                        >
                    </a>
                    <div class="card-body text-center">
                        <h6 class="card-title">{{ $product->name }}</h6>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-muted">まだいいねされた商品がありません。</p>
        @endforelse
    </div>
</div>
@endsection