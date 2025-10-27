@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/purchase.css') }}">

<form id="purchase-form" method="POST" action="{{ route('purchase.store', $product->id) }}">
    @csrf

    <input type="hidden" id="product-id" value="{{ $product->id }}">

    <div class="purchase-layout">
        <div class="purchase-left">
            <div class="image-info-box">
                @php
                    $imagePath = $product->image ?? $product->image_path;
                @endphp
                <img src="{{ $imagePath ? asset('storage/' . $imagePath) : 'https://via.placeholder.com/500x500?text=No+Image' }}"
                    alt="商品画像" class="product-image">

                <div class="product-info-text">
                    <p class="value">{{ $product->name }}</p>
                    <p class="value">¥{{ number_format($product->price) }}</p>
                </div>
            </div>

            <div class="divider-line"></div>

            <div class="form-group">
                <label class="label">支払い方法</label>
                <div class="custom-select-wrapper">
                    <div class="custom-select-display" onclick="toggleOptions()">
                        <span id="current-option">コンビニ払い</span>
                        <span class="arrow">&#9662;</span>
                    </div>
                    <ul class="custom-select-options" id="select-options">
                        <li onclick="selectOption('コンビニ払い')">
                            <span class="checkmark" id="check-conv">✓</span> コンビニ払い
                        </li>
                        <li onclick="selectOption('カード支払い')">
                            <span class="checkmark" id="check-card">✓</span> カード支払い
                        </li>
                    </ul>
                    <input type="hidden" name="payment_method" id="payment-method" value="コンビニ払い">
                </div>
            </div>

            <div class="divider-line"></div>

            <div class="form-group">
                <div class="address-box">
                    <div class="address-header">
                        <span class="address-label">配送先</span>
                        @if ($address)
                            <a href="{{ route('address.edit', ['id' => $address->id, 'item_id' => $product->id]) }}" class="change-link">変更する</a>
                        @else
                            <a href="{{ route('address.create', ['item_id' => $product->id]) }}" class="change-link">住所を登録する</a>
                        @endif
                    </div>
                    @if ($address)
                        <p class="address-line">〒{{ $address->postal_code }}</p>
                        <p class="address-line">{{ $address->address }}</p>
                        <p class="address-line">{{ $address->building_name }}</p>
                    @else
                        <p class="address-line">住所が登録されていません</p>
                    @endif
                </div>
            </div>

            <div class="divider-line"></div>
        </div>

        <div class="purchase-right">
            <div class="summary-box">
                <div class="summary-row">
                    <p class="label">商品代金</p>
                    <p class="summary-value">¥{{ number_format($product->price) }}</p>
                </div>
                <div class="summary-row">
                    <p class="label">支払い方法</p>
                    <p class="summary-value" id="selected-payment">コンビニ払い</p>
                </div>
            </div>

            <div class="form-button-right">
                <button type="submit" class="btn-buy" id="purchase-button">購入する</button>
            </div>
        </div>
    </div>
</form>

<script>
    function toggleOptions() {
        const options = document.getElementById('select-options');
        options.style.display = options.style.display === 'block' ? 'none' : 'block';
    }

    function selectOption(value) {
        document.getElementById('payment-method').value = value;
        document.getElementById('current-option').innerText = value;
        document.getElementById('selected-payment').innerText = value;

        const options = document.querySelectorAll('#select-options li');
        options.forEach(option => option.classList.remove('selected'));

        if (value === 'コンビニ払い') {
            document.getElementById('check-conv').parentElement.classList.add('selected');
        } else {
            document.getElementById('check-card').parentElement.classList.add('selected');
        }

        toggleOptions();
    }

    window.addEventListener('DOMContentLoaded', () => {
        selectOption('コンビニ払い');
    });

    document.getElementById('purchase-form').addEventListener('submit', function (e) {
        e.preventDefault();

        const method = document.getElementById('payment-method').value;
        const itemId = document.getElementById('product-id').value;

        if (!itemId) {
            alert("商品IDが取得できませんでした。");
            return;
        }

        if (method === 'カード支払い') {
            window.location.href = "/payment/card/" + itemId;
        } else if (method === 'コンビニ払い') {
            window.location.href = "/payment/convenience/confirm/" + itemId;
        }
    });

    window.addEventListener('click', function (e) {
        const wrapper = document.querySelector('.custom-select-wrapper');
        if (!wrapper.contains(e.target)) {
            document.getElementById('select-options').style.display = 'none';
        }
    });
</script>
@endsection