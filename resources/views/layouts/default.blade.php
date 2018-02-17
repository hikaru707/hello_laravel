<!DOCTYPE html>
<html>
  <head>
    <title>@yield('title', 'Sample')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  </head>
  <body>
      <header class="navbar navbar-fixed-top navbar-inverse">
        <div class="container">
          <div class="col-md-offset-1 col-md-10">
            <a href="/" id="logo">Sample App</a>
            <nav>
              <ul class="nav navbar-nav navbar-right">
                <li><a href="{{ route('help') }}">幫助</a></li>
                <li><a href="#">登入</a></li>
              </ul>
            </nav>
          </div>
        </div>
      </header>
  
      <div class="container">
        @yield('content')
      </div>    
    </body>
</html>