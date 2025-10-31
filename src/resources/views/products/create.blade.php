@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/product-form.css') }}">

<div class="custom-form-container">
    <h2 class="custom-form-title">商品の出品</h2>

    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="custom-form-group">
            <label>商品画像</label>
            <div class="image-upload-wrapper">
                <label for="imageInput" class="upload-box" id="uploadBox">
                    <span class="upload-btn-red" id="uploadBtn">画像を選択する</span>
                </label>
                <input type="file" name="image" id="imageInput" accept="image/*" style="display: none;">
            </div>
            @error('image')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="section-title">商品の詳細</div>

        <div class="custom-form-group category-group">
            <label>カテゴリー</label>
            <input type="hidden" name="category" id="selected-category">

            <div class="category-buttons">
                <div class="category-row">
                    <button type="button">ファッション</button>
                    <button type="button">家電</button>
                    <button type="button">インテリア</button>
                    <button type="button">レディース</button>
                    <button type="button">メンズ</button>
                    <button type="button">コスメ</button>
                </div>

                <div class="category-row">
                    <button type="button">本</button>
                    <button type="button">ゲーム</button>
                    <button type="button">スポーツ</button>
                    <button type="button">キッチン</button>
                    <button type="button">ハンドメイド</button>
                    <button type="button">アクセサリー</button>
                </div>

                <div class="category-row align-left">
                    <button type="button">おもちゃ</button>
                    <button type="button">ベビー・キッズ</button>
                </div>
            </div>
        </div>

        <div class="custom-form-group">
            <label>商品の状態</label>
            <select name="condition">
                <option value="">選択してください</option>
                <option value="良好">良好</option>
                <option value="目立った傷や汚れなし">目立った傷や汚れなし</option>
                <option value="やや傷や汚れあり">やや傷や汚れあり</option>
                <option value="状態が悪い">状態が悪い</option>
            </select>
        </div>

        <div class="section-title">商品名と説明</div>

        <div class="custom-form-group">
            <label>商品名</label>
            <input type="text" name="name" value="{{ old('name') }}">
        </div>

        <div class="custom-form-group">
            <label>ブランド名</label>
            <input type="text" name="brand" value="{{ old('brand') }}">
        </div>

        <div class="custom-form-group">
            <label>商品の説明</label>
            <textarea name="description" rows="4">{{ old('description') }}</textarea>
        </div>

        <div class="custom-form-group">
            <label>販売価格</label>
            <div class="price-input-wrapper">
                <span class="yen-symbol">¥</span>
                <input type="number" name="price" value="{{ old('price') }}">
            </div>
        </div>

        <div class="submit-btn">
            <button type="submit">出品する</button>
        </div>
    </form>
</div>

<script>
    const buttons = document.querySelectorAll('.category-buttons button');
    const hiddenInput = document.getElementById('selected-category');

    buttons.forEach(button => {
        button.addEventListener('click', () => {
            buttons.forEach(btn => btn.classList.remove('selected'));
            button.classList.add('selected');
            hiddenInput.value = button.textContent;
        });
    });

    const imageInput = document.getElementById('imageInput');
    const uploadBox = document.getElementById('uploadBox');
    const uploadBtn = document.getElementById('uploadBtn');

    imageInput.addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = function (e) {
            const img = document.createElement('img');
            img.src = e.target.result;
            img.style.maxHeight = '100%';
            img.style.maxWidth = '100%';
            img.style.objectFit = 'contain';
            img.style.display = 'block';
            img.style.margin = 'auto';

            uploadBox.innerHTML = '';
            uploadBox.appendChild(img);
            uploadBox.classList.add('hide');
        };
        reader.readAsDataURL(file);
    });
</script>
@endsection