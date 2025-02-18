@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<header class="header">
      <input type="text" placeholder="なにをお探しですか？">
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
</main>
@endsection