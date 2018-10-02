<!doctype html>
<html lang="{{ app()->getLocale() }}">

<head>
    <link href="{{ asset('css/backend--app.css') }}" rel="stylesheet" />
    @stack('styles')

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <meta name="app_name" content="{{ config('app.name') }}" />
    <meta name="app_url" content="{{ config('app.url') }}" />
    <meta name="csrf_token" content="{{ csrf_token() }}" />

    <title>@yield('title', config('app.name'))</title>
</head>

<body class="bg-light">
    <nav class="bg-dark navbar navbar-dark navbar-expand-md sticky-top">
        <a class="navbar-brand" href="#">@yield('title', config('app.name'))</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault"
            aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarsExampleDefault">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Home
                        <span class="sr-only">(current)</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" href="#">Disabled</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="https://example.com" id="dropdown01" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">Dropdown</a>
                    <div class="dropdown-menu" aria-labelledby="dropdown01">
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                </li>
            </ul>
            <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
        </div>
    </nav>

    @hasSection('breadcrumb')
        <nav>@yield('breadcrumb')</nav>
    @endif

    <main class="container-fluid" role="main">
        @include('cms::backend/v1/validation/error')
        @include('flash::message')
        @yield('content')
    </main>
    <script src="{{ asset('js/backend--app.js') }}"></script>
    @stack('scripts')
</body>

</html>
