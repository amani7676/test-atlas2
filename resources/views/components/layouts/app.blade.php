<!DOCTYPE html>
<html  lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'صفحه اصلی')</title>
    @yield('styles')
    @include('components.layouts.header')
</head>

<body>

    @include('components.layouts.menu')

    {{ $slot }}

    @yield('footer')
    @include('components.layouts.footer')

     @stack('scripts')
</body>

</html>
