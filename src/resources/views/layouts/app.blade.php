<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>coachtech flea market</title>
  <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
  <link rel="stylesheet" href="{{ asset('css/common.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.0/css/all.min.css">
  @yield('css')
</head>

<body>
  <header class="header">
    <div class="header__inner">
      <div class="header-logo">
        <a href="/"><img src="{{ asset('images/logo.svg') }}" alt="ロゴ"></a>
      </div>
      @if (!request()->is('login') && !request()->is('register'))
      <div class="header-search">
         <form id="search-form" action="/" method="GET">
            @csrf
          <input type="hidden" name="tab" value="{{ request('tab') }}">
          <input type="text" name="search" id="search-input" placeholder="なにをお探しですか？" value="{{ request('search') }}">
        </form>
      </div>
      <nav class="header-nav">
        <ul>
          @if (Auth::check())
          <li>
            <form method="POST" action="{{ route('logout') }}" class="logout-form">
              @csrf
              <button type="submit">ログアウト</button>
            </form>
          </li>
          <li><a href="/mypage">マイページ</a></li>
          <li><a href="/sell" class="sell">出品</a></li>
          @else
          <li><a href="/login">ログイン</a></li>
          <li><a href="/mypage">マイページ</a></li>
          <li><a href="/sell" class="sell">出品</a></li>
          @endif
        </ul>
      </nav>
      @endif
    </div>
  </header>

  <main>
    @yield('content')
  </main>

  <script>
    document.getElementById('search-input').addEventListener('keypress', function (e) {
      if (e.key === 'Enter') {
        e.preventDefault();
        document.getElementById('search-form').submit();
      }
    });
  </script>
</body>

</html>