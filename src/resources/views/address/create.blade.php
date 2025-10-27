@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/address.css') }}">

<div class="address-form-container">
    <h2 class="form-title">住所を登録する</h2>

    <form method="POST" action="{{ route('address.store') }}">
        <input type="hidden" name="item_id" value="{{ $item_id }}">
        @csrf

        <div class="form-group">
            <label for="postal_code">郵便番号</label>
            <input type="text" id="postal_code" name="postal_code" value="{{ old('postal_code') }}">
        </div>

        <div class="form-group">
            <label for="address">住所</label>
            <input type="text" id="address" name="address" value="{{ old('address') }}">
        </div>

        <div class="form-group">
            <label for="building_name">建物名</label>
            <input type="text" id="building_name" name="building_name" value="{{ old('building_name') }}">
        </div>

        <div class="form-button">
            <button type="submit">登録する</button>
        </div>
    </form>
</div>
@endsection