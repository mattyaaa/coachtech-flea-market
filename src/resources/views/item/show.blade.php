@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/item/show.css') }}">
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
        <p class="item-info-brand">{{ $item->brand ?? 'ブランド情報なし' }}</p>
        <p class="item-info-price">{{ $item->formatted_price }}</p>
        <div class="item-detail-stats">
          <span class="item-like-button" data-item-id="{{ $item->id }}">
            <i class="fa-regular fa-star {{ $item->is_favorited ? 'liked' : '' }}"></i> 
            <span class="item-favorites-count">{{ $item->favorites_count }}</span>
          </span>
          <span class="item-comments-count"><i class="fa-regular fa-comment"></i> {{ $item->comments_count }}</span>
        </div>
        <a href="/purchase/{{ $item->id }}" class="btn btn-primary">購入手続きへ</a>
        <h3>商品説明</h3>
        <p class="item-detail-description">{{ $item->description }}</p>
        <h3>商品の情報</h3>
        <div class="item-extra-info">
          <p>カテゴリー
            @foreach ($item->categories as $category)
              {{ $category->name }}@if(!$loop->last), @endif
            @endforeach
          </p>
          <p>商品の状態 {{ $item->condition }}</p>
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
      <div class="comment-form">
        <h4>商品へのコメント</h4>
        <form action="/item/{{ $item->id }}/comment" method="POST">
          @csrf
          <div class="form-group">
            <textarea name="comment" class="form-control" rows="10" ></textarea>
          </div>
          <button type="submit" class="btn btn-primary">コメントを送信する</button>
        </form>
      </div>
    </div>
  </div>
</div>
</div>
</main>
@endsection