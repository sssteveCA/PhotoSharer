<!DOCTYPE html>
<html>
    <head>
        <title>@yield('title')</title>
        @yield('meta')
        @section('links')
            @vite([ 'resources/sass/app.scss' ])
        @show
        @section('scripts')
            @vite([ 'resources/js/app.js' ])
        @show
    </head>
    <body>
        @include('partials.menu',[])
        <div class="content my-5">
            @yield('content')
        </div>
    </body>
</html>