@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/profile/show.css') }}">
@endsection

@section('content')
<main class="profile-main">
  <div class="profile-container">
    <div class="profile-header">
      <div class="profile-image">
        @if ($user->profile && $user->profile->profile_image)
          <img src="{{ asset('storage/' . $user->profile->profile_image) }}" alt="{{ $user->name }}">
        @else
          <img src="{{ asset('images/default_profile.png') }}" alt="プロフィール画像{{ $user->name }}">
        @endif
      </div>
      <div class="profile-info">
        <h1 class="user-name">ユーザー名{{ $user->name }}</h1>
        <a href="{{ url('/mypage/profile') }}" class="btn btn-secondary">プロフィールを編集</a>
      </div>
    </div>

    <div class="profile-content">
      <div class="links">
        <a href="/mypage?tab=sell" class="{{ request('tab') == 'sell' ? 'highlight' : '' }}">出品した商品</a>
        <a href="/mypage?tab=buy" class="{{ request('tab') == 'buy' ? 'highlight' : '' }}">購入した商品</a>
      </div>

    @if (request('tab') == 'sell')
        @if ($products->count() > 0)
          <div class="items">
            @foreach ($products as $product)
              <div class="item">
                <a href="{{ url('/item/' . $product->id) }}">
                  @if ($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                  @else
                    <img src="{{ asset('images/default.png') }}" alt="{{ $product->name }}">
                  @endif
                </a>
              </div>
            @endforeach
          </div>
        @else
          <p>出品した商品はありません。</p>
        @endif
      @elseif (request('tab') == 'buy')
        @if ($purchases->count() > 0)
          <div class="items">
            @foreach ($purchases as $purchase)
              <div class="item">
                <a href="{{ url('/item/' . $purchase->product->id) }}">
                  @if ($purchase->product->image)
                    <img src="{{ asset('storage/' . $purchase->product->image) }}" alt="{{ $purchase->product->name }}">
                  @else
                    <img src="{{ asset('images/default.png') }}" alt="{{ $purchase->product->name }}">
                  @endif
                </a>
              </div>
            @endforeach
          </div>
        @else
          <p>購入した商品はありません。</p>
        @endif
      @else
        <p>表示するタブを選択してください。</p>
      @endif
    </div>
  </div>
</main>
@endsection