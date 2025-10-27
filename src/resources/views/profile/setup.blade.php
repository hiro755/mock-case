@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/setup.css') }}">

<div class="container">
    <h2>プロフィール設定</h2>

    <div class="profile-area">
        <img id="preview" class="profile-preview"
            src="{{ $user->profile_image ? asset('storage/' . $user->profile_image) : asset('images/default-avatar.png') }}"
            alt="プロフィール画像">

        <div class="upload-wrapper">
            <button type="button" class="image-upload-btn" onclick="document.getElementById('profile_image').click();">
                画像を選択する
            </button>
            <input type="file" id="profile_image" name="profile_image" accept="image/*" onchange="previewImage(event)" style="display: none;">
        </div>
    </div>

    <form action="{{ route('profile.setup.submit') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div>
            <label for="name">ユーザー名</label>
            <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}">
            @error('name') <p class="error">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="postal_code">郵便番号</label>
            <input type="text" id="postal_code" name="postal_code" value="{{ old('postal_code', $user->postal_code) }}">
            @error('postal_code') <p class="error">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="address">住所</label>
            <input type="text" id="address" name="address" value="{{ old('address', $user->address) }}">
            @error('address') <p class="error">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="phone_number">建物名</label>
            <input type="text" id="phone_number" name="phone_number" value="{{ old('phone_number', $user->phone_number) }}">
            @error('phone_number') <p class="error">{{ $message }}</p> @enderror
        </div>

        <button type="submit">更新する</button>
    </form>
</div>

<script>
function previewImage(event) {
    const reader = new FileReader();
    reader.onload = function () {
        document.getElementById('preview').src = reader.result;
    };
    if (event.target.files[0]) {
        reader.readAsDataURL(event.target.files[0]);
    }
}

window.addEventListener('load', () => {
    window.scrollTo({ top: 0 });
});
</script>
@endsection