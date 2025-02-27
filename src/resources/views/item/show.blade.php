@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/show.css') }}">
@endsection

@section('content')
<main>
  <div class="container">
    <div class="item-detail">
      <div class="item-image">
        @if ($item->image)
          <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}">
        @else
          <img src="{{ asset('images/default.png') }}" alt="{{ $item->name }}">
        @endif
      </div>
      <div class="item-info">
        <h2>{{ $item->name }}</h2>
        <p>ブランド: {{ $item->brand ?? 'ブランド情報なし' }}</p>
        <p>価格: {{ $item->formatted_price }}</p>
        <div class="item-stats">
          <span><i class="fa fa-thumbs-up"></i> {{ $item->likes_count }}</span>
          <span><i class="fa fa-comments"></i> {{ $item->comments_count }}</span>
        </div>
        <a href="/purchase/{{ $item->id }}" class="btn btn-primary">購入手続きへ</a>
        <h3>商品説明</h3>
        <p>{{ $item->description }}</p>
        <h3>商品の情報</h3>
        <div class="item-extra-info">
          <p>カテゴリ: 
            @foreach ($item->categories as $category)
              {{ $category->name }}@if(!$loop->last), @endif
            @endforeach
          </p>
          <p>商品の状態: {{ $item->condition->name }}</p>
        </div>
      </div>
    </div>
    <div class="comments-section">
      <h3>コメント ({{ $item->comments_count }})</h3>
      @foreach ($item->comments as $comment)
        <div class="comment">
          <div class="comment-user">
            <p>{{ $comment->user->name }}</p>
          </div>
          <div class="comment-content">
            <p>{{ $comment->content }}</p>
          </div>
        </div>
      @endforeach
      @auth
        <div class="comment-form">
          <h4>商品へのコメント</h4>
          <form action="/item/{{ $item->id }}/comment" method="POST">
            @csrf
            <div class="form-group">
              <textarea name="comment" class="form-control" rows="3" placeholder="コメントを入力してください"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">コメントを送信する</button>
          </form>
        </div>
      @endauth
    </div>
  </div>
</main>
@endsection