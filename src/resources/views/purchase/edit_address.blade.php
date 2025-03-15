@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase/edit_address.css') }}">
@endsection

@section('content')
<main class="edit-address-main">
  <div class="edit-address-container">
    <h1 class="edit-address-title">住所の変更</h1>
    <form action="{{ url('/purchase/address/' . $item->id) }}" method="POST" class="edit-address-form">
      @csrf
      @method('PUT')
      <div class="form-group">
        <label for="postal_code" class="edit-address-label">郵便番号</label>
        <input type="text" id="postal_code" name="postal_code" value="{{ old('postal_code', $profile->postal_code) }}" required class="edit-address-input">
      </div>
      <div class="form-group">
        <label for="address" class="edit-address-label">住所</label>
        <input type="text" id="address" name="address" value="{{ old('address', $profile->address) }}" required class="edit-address-input">
      </div>
      <div class="form-group">
        <label for="building" class="edit-address-label">建物名</label>
        <input type="text" id="building" name="building" value="{{ old('building', $profile->building_name) }}" class="edit-address-input">
      </div>
      <button type="submit" class="edit-address-button">更新する</button>
    </form>
  </div>
</main>
@endsection