<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FashionablyLate - @yield('title')</title>

    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    
    @if (View::hasSection('css'))
            @yield('css')
    @endif
</head>
<body>
    {{-- ヘッダー --}}
    <header>
    <h1>FashionablyLate</h1>
    <div class="header-links">
        @yield('header-links')
    </div>
</header>
    <main style="padding: 40px 0;">
        @yield('content')
    </main>

  {{-- フッター --}}
    @if (!isset($noHeaderFooter) || !$noHeaderFooter)
    <footer style="text-align: center; padding: 20px; font-size: 12px; color: #aaa;">
        &copy; 2025 FashionablyLate All Rights Reserved.
    </footer>
    @endif


    @yield('js')


</body>
</html>