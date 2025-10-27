@extends('layouts.app')

@section('head')
    <link rel="stylesheet" href="{{ asset('css/profile_edit.css') }}?v=3">
@endsection

@section('content')
<div class="profile-edit-container">
    <h2>プロフィール設定</h2>

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="profile-image-section">
            <img id="preview-image"
                src="{{ $user->profile_image ? asset('storage/' . $user->profile_image) : asset('images/default-icon.png') }}"
                alt="プロフィール画像"
                class="profile-img">

            <div class="upload-wrapper">
                <label class="upload-btn">
                    画像を選択する
                    <input type="file" name="profile_image" id="profile_image" accept="image/*">
                </label>
            </div>
        </div>

        <div class="form-group">
            <label>ユーザー名</label>
            <input type="text" name="full_name" value="{{ old('full_name', $user->full_name) }}" class="form-control">
        </div>

        <div class="form-group">
            <label>郵便番号</label>
            <input type="text" name="postal_code" value="{{ old('postal_code', $user->postal_code) }}" class="form-control">
        </div>

        <div class="form-group">
            <label>住所</label>
            <input type="text" name="address" value="{{ old('address', $user->address) }}" class="form-control">
        </div>

        <div class="form-group">
            <label>建物名</label>
            <input type="text" name="building" value="{{ old('building', $user->building) }}" class="form-control">
        </div>

        <button type="submit" class="btn-danger">更新する</button>
    </form>
</div>

<script>
document.getElementById('profile_image').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(event) {
            document.getElementById('preview-image').src = event.target.result;
        };
        reader.readAsDataURL(file);
    }
});
</script>
@endsection