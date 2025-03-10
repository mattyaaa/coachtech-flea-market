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
        <h1>ユーザー名{{ $user->name }}</h1>
        <a href="{{ url('/mypage/profile') }}" class="btn btn-secondary">プロフィールを編集</a>
      </div>
    </div>

    <div class="profile-content">
      <div class="profile-section">
        <h2>出品した商品一覧</h2>
        @if ($products->count() > 0)
          <ul>
            @foreach ($products as $product)
              <li>
                <a href="{{ url('/item/' . $product->id) }}">{{ $product->name }}</a>
              </li>
            @endforeach
          </ul>
        @else
          <p>出品した商品はありません。</p>
        @endif
      </div>

      <div class="profile-section">
        <h2>購入した商品一覧</h2>
        @if ($purchases->count() > 0)
          <ul>
            @foreach ($purchases as $purchase)
              <li>
                <a href="{{ url('/item/' . $purchase->product->id) }}">{{ $purchase->product->name }}</a>
              </li>
            @endforeach
          </ul>
        @else
          <p>購入した商品はありません。</p>
        @endif
      </div>
    </div>
  </div>
</main>
@endsection