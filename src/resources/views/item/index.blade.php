@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<main>
  <div class="content">
    <div class="links">
      <a href="" class="recommended">おすすめ</a>
      <a href="/?tab=mylist">マイリスト</a>
    </div>
</main>
@endsection