@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/address.css') }}">

<div class="address-form-container">
    <h2 class="form-title">住所の変更</h2>

    <form method="POST" action="{{ route('address.update', $address->id) }}">
        @csrf
        @method('PUT')

        <input type="hidden" name="item_id" value="{{ $item_id }}">

        <div class="form-group">
            <label for="postal_code">郵便番号</label>
            <input type="text" id="postal_code" name="postal_code" value="{{ old('postal_code', $address->postal_code) }}">
        </div>

        <div class="form-group">
            <label for="address">住所</label>
            <input type="text" id="address" name="address" value="{{ old('address', $address->address) }}">
        </div>

        <div class="form-group">
            <label for="building_name">建物名</label>
            <input type="text" id="building_name" name="building_name" value="{{ old('building_name', $address->building_name) }}">
        </div>

        <div class="form-button">
            <button type="submit">更新する</button>
        </div>
    </form>
</div>
@endsection