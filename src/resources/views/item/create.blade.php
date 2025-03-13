@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/item/create.css') }}">
@endsection

@section('content')
<main>
  <div class="container">
    <h1>商品の出品</h1>
    <form action="/sell" method="POST" enctype="multipart/form-data">
      @csrf
      <!-- 商品画像 -->
      <div class="form-group">
        <label for="image">商品画像</label>
        <div>
          <div class="image-frame">
          <label for="image" class="btn btn-secondary">画像を選択する</label>
          <input type="file" class="form-control-file" id="image" name="image" style="display: none;">
          </div>
        </div>
      </div>

      <h2>商品の詳細</h2>
      <!-- カテゴリー -->
      <div class="form-group">
        <label for="categories">カテゴリー</label>
      </div>
        <div id="categories" class="category-container">
          @foreach($categories as $category)
            <div class="form-check category-check">
              <input class="form-check-input" type="checkbox" id="category{{ $category->id }}" name="categories[]" value="{{ $category->id }}">
              <label class="form-check-label" for="category{{ $category->id }}">
                {{ $category->name }}
              </label>
            </div>
          @endforeach
        </div>
      <!-- 商品の状態 -->
      <div class="form-group">
        <label for="condition">商品の状態</label>
        <div>
          <select class="form-control" id="condition" name="condition_id">
            <option value="" disabled selected>選択してください</option>
            @foreach($conditions as $condition)
              <option value="{{ $condition->id }}">{{ $condition->name }}</option>
            @endforeach
          </select>
        </div>
      </div>

      <h2>商品名と説明</h2>
      <!-- 商品名 -->
      <div class="form-group">
        <label for="name">商品名</label>
        <div>
          <input type="text" class="form-control" id="name" name="name" required>
        </div>
      </div>
      <!-- ブランド名 -->
      <div class="form-group">
        <label for="brand">ブランド名</label>
        <div>
          <input type="text" class="form-control" id="brand" name="brand">
        </div>
      </div>
      <!-- 商品の説明 -->
      <div class="form-group">
        <label for="description">商品の説明</label>
        <div>
          <textarea class="form-control" id="description" name="description" rows="5" required></textarea>
        </div>
      </div>
      <!-- 販売価格 -->
      <div class="form-group">
        <label for="price">販売価格</label>
        <div class="input-group">
          <span class="input-group-text">¥</span>
          <input type="text" class="form-control yen-input" id="price" name="price" required>
        </div>
      </div>

      <!-- 出品するボタン -->
      <button type="submit" class="btn btn-primary">出品する</button>
    </form>
  </div>
</main>
@endsection