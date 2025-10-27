@extends('layouts.app')

@section('content')
<div class="mypage-wrapper">

    <div class="profile-header aligned-layout">
        <div class="user-info-horizontal">
            <div class="icon-wrapper">
                <img src="{{ $user->profile_image ? asset('storage/' . $user->profile_image) : asset('images/default-icon.png') }}"
                    alt="プロフィール画像" class="profile-image">
            </div>
            <div>
                <div class="user-name">{{ $user->name }}</div>
            </div>
        </div>
        <div class="edit-button-container">
            <a href="{{ route('profile.edit') }}" class="edit-button">プロフィールを編集</a>
        </div>
    </div>

    <div class="tab-wrapper">
        <button class="tab-button active" data-tab="exhibited">出品した商品</button>
        <button class="tab-button" data-tab="purchased">購入した商品</button>
    </div>

    <div class="full-width-border"></div>

    <div class="tab-content active" id="exhibited">
        <div class="item-grid">
            @forelse ($exhibited as $product)
                <div class="item-card">
                    <a href="{{ route('item.show', $product->id) }}">
                        <div class="item-image">
                            @if ($product->image_path)
                                <img src="{{ asset('storage/' . $product->image_path) }}" alt="商品画像">
                            @else
                                <div class="text-center py-5">画像なし</div>
                            @endif
                        </div>
                        <div class="item-name">{{ $product->name }}</div>
                    </a>
                </div>
            @empty
                <p>出品した商品はまだありません。</p>
            @endforelse
        </div>
    </div>

    <div class="tab-content" id="purchased">
        <div class="item-grid">
            @forelse ($purchased as $product)
                <div class="item-card">
                    <a href="{{ route('item.show', $product->id) }}">
                        <div class="item-image">
                            @if ($product->image_path)
                                <img src="{{ asset('storage/' . $product->image_path) }}" alt="商品画像">
                            @else
                                <div class="text-center py-5">画像なし</div>
                            @endif
                        </div>
                        <div class="item-name">{{ $product->name }}</div>
                    </a>
                </div>
            @empty
                <p>購入した商品はまだありません。</p>
            @endforelse
        </div>
    </div>

</div>
@endsection

@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const tabButtons = document.querySelectorAll(".tab-button");
        const tabContents = document.querySelectorAll(".tab-content");

        tabButtons.forEach(button => {
            button.addEventListener("click", () => {
                const targetId = button.getAttribute("data-tab");

                tabButtons.forEach(btn => btn.classList.remove("active"));
                tabContents.forEach(content => content.classList.remove("active"));

                button.classList.add("active");
                document.getElementById(targetId).classList.add("active");
            });
        });
    });
</script>
@endsection