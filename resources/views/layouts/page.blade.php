<!DOCTYPE html>
<html>
    <head>
        <title>@yield('title')</title>
        @yield('meta')
        @section('links')
            @vite([ 'resources/sass/app.scss' ])
        @show
        @section('scripts')
            <script src="{{ asset('js/app.js') }}"></script>
            <script src="{{ asset('js/jquery.js') }}"></script>
            <script src="{{ asset('js/menu.js') }}"></script>
        @show
    </head>
    <body>
        @include('partials.menu',[])
        <div class="content my-5">
            @yield('content')
        </div>
    </body>
</html>