@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
@endsection

@section('content')
<main>
  <div class="container">
    <div class="purchase-details">
      <div class="item-image">
        @if ($item->image)
          <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}">
        @else
          <img src="{{ asset('images/default.png') }}" alt="{{ $item->name }}">
        @endif
      </div>
      <div class="item-info">
        <h2>{{ $item->name }}</h2>
        <p class="item-info-price">{{ $item->formatted_price }}</p>
    </div>
    <div class="purchase-form">
      <h3>支払い方法</h3>
      <div class="form-group">
        <label for="payment_method">支払い方法</label>
        <select name="payment_method" class="form-control" required>
            <option value="" disabled selected>選択してください</option>
            <option value="コンビニ支払い">コンビニ支払い</option>
            <option value="カード支払い">カード支払い</option>
        </select>
      </div>
      <h3>配送先</h3>
      <a href="/purchase/{{ $item->id }}/change-address" class="btn btn-secondary">住所を変更する</a>
      <form action="/purchase/{{ $item->id }}" method="POST">
        @csrf
        <div class="form-group">
          <p class="form-control-static">〒{{ $profile->postal_code }}</p>
        </div>
        <div class="form-group">
          <p class="form-control-static">{{ $profile->address }}</p>
        </div>
        <div class="form-group">
          <p class="form-control-static">{{ $profile->building_name }}</p>
        </div>
        <div class="subtotal">
          <h3>小計</h3>
          <p>商品代金: {{ $item->formatted_price }}</p>
          <p>支払い方法: <span id="selected-payment-method">選択してください</span></p>
        </div>
        <button type="submit" class="btn btn-primary">購入する</button>
      </form>
    </div>
  </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const paymentMethodSelect = document.querySelector('select[name="payment_method"]');
  const selectedPaymentMethodSpan = document.getElementById('selected-payment-method');

  paymentMethodSelect.addEventListener('change', function() {
    selectedPaymentMethodSpan.textContent = paymentMethodSelect.options[paymentMethodSelect.selectedIndex].text;
  });
});
</script>
@endsection