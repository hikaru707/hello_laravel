<!DOCTYPE html>
<html>
  <head>
    <title>@yield('title', 'Sample')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  </head>
  <body>
    @yield('content')
  </body>
</html>