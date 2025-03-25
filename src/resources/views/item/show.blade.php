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
          <p><span class="label">カテゴリー</span><span class="value">
            @foreach ($item->categories as $category)
              <span class="category-label">{{ $category->name }}</span>@if(!$loop->last), @endif
            @endforeach
          </span></p>
          <p><span class="label">商品の状態</span><span class="value">{{ $item->condition->name }}</span></p>
        </div>
        <div class="comments-section">
      <h3>コメント ({{ $item->comments_count }})</h3>
      @foreach ($item->comments as $comment)
        <div class="comment">
              <div class="comment-user">
                @if ($comment->user->profile->profile_image)
                  <img src="{{ asset('storage/' . $comment->user->profile->profile_image) }}" alt="{{ $comment->user->profile->name }}" class="comment-user-image">
                @else
                  <img src="{{ asset('images/default-profile.png') }}" alt="{{ $comment->user->profile->name }}" class="comment-user-image">
                @endif
                <p>{{ $comment->user->profile->name }}</p>
              </div>
              <div class="comment-content">
                <p>{{ $comment->comment }}</p>
              </div>
            </div>
      @endforeach
      <div class="comment-form">
        <h4>商品へのコメント</h4>
        @error('comment')
          <div class="alert alert-danger">{{ $message }}</div>
        @enderror
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

<script>
document.addEventListener('DOMContentLoaded', function() {
  var likeButton = document.querySelector('.item-like-button');

  likeButton.addEventListener('click', function() {
    var itemId = this.getAttribute('data-item-id');
    var likeIcon = this.querySelector('i');
    var likeCount = this.querySelector('.item-favorites-count');
    var isLiked = likeIcon.classList.contains('liked');
    var url = isLiked ? '/item/' + itemId + '/favorite' : '/item/' + itemId + '/favorite';
    var method = isLiked ? 'DELETE' : 'POST';

    fetch(url, {
      method: method,
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
      },
    })
    .then(response => {
      if (!response.ok) {
        throw new Error('Network response was not ok');
      }
      return response.json();
    })
    .then(data => {
      if (data.success) {
        likeCount.textContent = data.favorites_count;
        likeIcon.classList.toggle('liked');
      } else {
        console.error('Error:', data.message);
      }
    })
    .catch(error => {
      console.error('Error:', error);
      alert('An error occurred. Please try again later.');
    });
  });
});
</script>
@endsection