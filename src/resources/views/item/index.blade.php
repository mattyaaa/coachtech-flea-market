@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<main>
  <div class="content">
    <div class="links">
      <a href="" class="{{ auth()->check() ? '' : 'highlight' }}">おすすめ</a>
      <a href="/?tab=mylist" class="{{ auth()->check() ? 'highlight' : '' }}">マイリスト</a>
    </div>
    <div class="items">
      @foreach ($items as $item)
        <div class="item">
          <a href="/item/{{ $item->id }}">
            @if ($item->image)
              <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}">
            @else
              <img src="{{ asset('images/default.png') }}" alt="{{ $item->name }}">
            @endif
            <p>{{ $item->name }}</p>
          </a>
        </div>
      @endforeach
    </div>
  </div>
</main>
@endsection