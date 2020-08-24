<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />

  <title>Laravel</title>
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
  <!-- Scripts -->
  <script src="{{ asset('js/app.js') }}" defer></script>

  <!-- Styles -->

  <style>
  html, body {
    background-color: rgb(0,150,214) !important;
    color: rgb(233, 233, 233);
    font-family: 'Nunito', sans-serif;
    font-weight: 200;
    height: 100vh;
    margin: 0;
  }

  .full-height {
    height: 100vh;
  }

  .flex-center {
    align-items: center;
    display: flex;
    justify-content: center;
  }

  .position-ref {
    position: relative;
  }

  .top-right {
    position: absolute;
    right: 10px;
    top: 18px;
  }

  .content {
    text-align: center;
  }

  .title {
    font-size: 84px;
  }

  .links > a {
    color: #e9e9e9;
    padding: 0 25px;
    font-size: 13px;
    font-weight: 600;
    letter-spacing: .1rem;
    text-decoration: none;
    text-transform: uppercase;
  }
  .links a:hover {
    color: #c4c4c4;
    text-decoration: none;
  }

  .m-b-md {
    margin-bottom: 30px;
  }
  </style>
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="container">
  <div class="flex-center position-ref full-height">
    @if (Route::has('login'))
      <div class="top-right links">
        {{-- <div class="btn-group">
          <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Lang
          </button>
          <div class="dropdown-menu">

            @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
              <li>
                <a class="dropdown-item" rel="alternate" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                  {{ $properties['native'] }}
                </a>&nbsp;
              </li>
            @endforeach
          </div>
        </div> --}}

        {{-- @auth
          <a href="{{ url('/home') }}">Home</a>
        @else
          <a href="{{ route('login') }}">Login</a>

          @if (Route::has('register'))
            <a href="{{ route('register') }}">Register</a>
          @endif
        @endauth --}}
      </div>
    @endif

    <div class="content">
      <div class="title m-b-md ">
        {{-- Micro sa --}}
        <img class="col-9 col-md-7 col-lg-5" src="{{asset('images/logo-micro.png')}}" alt="">
      </div>
      {{-- {{}} --}}

          <div class="row">
        @foreach (App\Models440\Country::all() as $country)
          <div class="links pb-4 col-12 col-md-6 col-lg-4">
            <a class="" href="{{route('setCountry', $country->country_shortcode)}}">{{$country->country_desc}}</a>
            {{-- {{$country->country_desc}} --}}
          </div>
        @endforeach

      </div>


    </div>
  </div>
</body>
</html>
