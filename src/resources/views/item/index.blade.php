@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/item/index.css') }}">
@endsection

@section('content')
<main>
  <div class="content">
    <div class="links">
      <a href="/" class="{{ request('tab') != 'mylist' ? 'highlight' : '' }}">おすすめ</a>
      <a href="/?tab=mylist" class="{{ request('tab') == 'mylist' ? 'highlight' : '' }}">マイリスト</a>
    </div>
    <div class="items">
      @if (request('tab') == 'mylist' && !Auth::check())
      @else
        @foreach ($items as $item)
          <div class="item">
            @if ($item->status == 'sold')
              <div>
                @if ($item->image)
                  <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}">
                @else
                  <img src="{{ asset('images/default.png') }}" alt="{{ $item->name }}">
                @endif
                <p>{{ $item->name }}</p>
                <p class="sold">Sold</p>
              </div>
            @else
              <a href="/item/{{ $item->id }}">
                @if ($item->image)
                  <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}">
                @else
                  <img src="{{ asset('images/default.png') }}" alt="{{ $item->name }}">
                @endif
                <p>{{ $item->name }}</p>
                @if ($item->status == 'sold')
                  <p class="sold">Sold</p>
                @endif
              </a>
            @endif
          </div>
        @endforeach
      @endif
    </div>
  </div>
</main>
@endsection