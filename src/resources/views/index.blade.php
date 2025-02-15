@extends('app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<header class="header">
  <div class="header__inner">
    <div class="header-logo">
      <img src="{{ asset('images/logo.svg') }}" alt="ロゴ">
    </div>
    <div class="header-search">
      <input type="text" placeholder="商品を検索">
    </div>
    <nav class="header-nav">
      <ul>
        <li><a href="/login">ログイン</a></li>
        <li><a href="/mypage">マイページ</a></li>
        <li><a href="/sell">出品</a></li>
      </ul>
    </nav>
  </div>
</header>

<main>
  <div class="content">
    <div class="links">
      <a href="">おすすめ</a>
      <a href="/?tab=mylist">マイリスト</a>
    </div>
    <div class="product-list">
      <!-- ここに商品情報をループで表示 -->
      @foreach($products as $product)
      <div class="product-item">
        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
        <h2>{{ $product->name }}</h2>
      </div>
      @endforeach
    </div>
  </div>
</main>
@endsection