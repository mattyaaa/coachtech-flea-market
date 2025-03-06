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
      <div class="purchase-column">
        <div class="subtotal-box">
          <div class="subtotal-item-box">
            <p class="subtotal-item"><span>商品代金</span><span>{{ $item->formatted_price }}</span></p>
          </div>
          <div class="subtotal-item-box">
            <p class="subtotal-item"><span>支払い方法</span><span id="selected-payment-method">選択してください</span></p>
          </div>
        </div>
        <button type="submit" class="btn btn-primary">購入する</button>
      </div>
    </div>
    <hr class="section-divider">
    <div class="purchase-form">
      <div class="purchase-columns">
        <div class="purchase-column">
          <div class="form-group">
            <label for="payment_method">支払い方法</label>
            <select name="payment_method" class="form-control" required>
                <option value="" disabled selected>選択してください</option>
                <option value="コンビニ支払い">コンビニ支払い</option>
                <option value="カード支払い">カード支払い</option>
            </select>
          </div>
          <hr class="section-divider"> 
          <div class="purchase-column delivery-address">
            <div class="address-header">
              <h3>配送先</h3>
              <a href="/purchase/{{ $item->id }}/change-address" class="btn btn-secondary">変更する</a>
            </div>
            <div class="form-group">
              <p class="form-control-static">〒{{ $profile->postal_code }}</p>
            </div>
            <div class="form-group">
              <p class="form-control-static">{{ $profile->address }}</p>
            </div>
            <div class="form-group">
              <p class="form-control-static">{{ $profile->building_name }}</p>
            </div>
          </div>
        </div>
      </div>
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