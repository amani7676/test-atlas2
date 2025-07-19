<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'صفحه اصلی')</title>
    @yield('styles')
    @include('main.header')
</head>

<body>

    @include('main.menu')
    <div>
        @yield('body')
    </div>
    @yield('footer')
    @include('main.footer')

     @stack('scripts')
</body>

</html>
